<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_category(): void
    {
        $response = $this->get('/admin/categories');

        $response->assertStatus(200);
    }
    /** If your admin routes are behind auth, this helps. */
    protected function signIn(): void
    {
        if (class_exists(Admin::class)) {

            $admin = Admin::factory()->create();
            $this->actingAs($admin, 'admin');
        } else {
            // If no auth middleware, this is fine.
            $this->withoutMiddleware();
        }
    }

    public function test_category_index(): void
    {
        $this->signIn();
        $cats = Category::factory()->count(3)->create();

        $res = $this->get(route('admin.categories.index'));
        $res->assertStatus(200);

        $res->assertOk()
            ->assertViewIs('admin.categories.index')
            ->assertViewHas('categories', function ($collection) use ($cats) {
                return $collection->count() === 3 &&
                    $collection->pluck('id')->diff($cats->pluck('id'))->isEmpty();
            });
        foreach ($cats as $c) {
            $res->assertSee($c->name);
        }
    }

    public function test_create_displays_the_create_form()
    {
        $this->signIn();

        $this->get(route('admin.categories.create'))
            ->assertOk()
            ->assertViewIs('admin.categories.create');
    }

    public function test_store_persists_a_new_category_and_redirects_with_flash()
    {
        $this->signIn();

        $payload = ['name' => 'Summer Shoes'];

        $res = $this->post(route('admin.categories.store'), $payload);

        $res->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('success', 'Category created successfully.');

        $this->assertDatabaseHas('categories', [
            'name' => 'Summer Shoes',
            'slug' => Str::slug('Summer Shoes'),
        ]);
    }

    public function test_store_fails_validation_when_name_is_missing()
    {
        $this->signIn();

        $res = $this->from(route('admin.categories.create'))
            ->post(route('admin.categories.store'), []);

        $res->assertRedirect(); // back
        $res->assertSessionHasErrors(['name']);
        $this->assertDatabaseCount('categories', 0);
    }

    public function test_edit_displays_the_edit_form()
    {
        $this->signIn();

        $category = Category::factory()->create();

        $this->get(route('admin.categories.edit', $category))
            ->assertOk()
            ->assertViewIs('admin.categories.edit')
            ->assertViewHas('category', function ($bound) use ($category) {
                return $bound->is($category);
            });
    }

    public function test_update_changes_the_category_and_redirects_with_flash()
    {
        $this->signIn();

        $category = Category::factory()->create(['name' => 'Old Name']);
        $payload  = ['name' => 'Fresh Name'];

        $res = $this->put(route('admin.categories.update', $category), $payload);

        $res->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('success', 'Category has been updated successfully.');

        $this->assertDatabaseHas('categories', [
            'id'   => $category->id,
            'name' => 'Fresh Name',
            'slug' => Str::slug('Fresh Name'),
        ]);
    }

    public function test_update_fails_validation_when_name_is_missing()
    {
        $this->signIn();

        $category = Category::factory()->create();

        $res = $this->from(route('admin.categories.edit', $category))
            ->put(route('admin.categories.update', $category), []);

        $res->assertRedirect();
        $res->assertSessionHasErrors(['name']);
        $this->assertDatabaseHas('categories', ['id' => $category->id]); // unchanged still exists
    }

    public function test_destroy_deletes_the_category_and_redirects_with_flash()
    {
        $this->signIn();

        $category = Category::factory()->create();

        $res = $this->delete(route('admin.categories.destroy', $category));

        $res->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('success', 'Category deleted successfully.');

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
