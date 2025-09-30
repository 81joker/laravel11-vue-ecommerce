<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected ?Admin $admin = null;

    protected function setUp(): void
    {
        parent::setUp();

        // If your admin guard exists, sign in once for all tests here.
        if (class_exists(Admin::class)) {
            $this->admin = Admin::factory()->create();
            $this->actingAs($this->admin, 'admin');
        } else {
            $this->withoutMiddleware();
        }
    }

    /** Convenience: make N categories and return the collection */
    protected function makeCategories(int $count = 1)
    {
        return Category::factory()->count($count)->create();
    }

    /** Convenience: make a single category and return it */
    protected function makeCategory(array $overrides = []): Category
    {
        return Category::factory()->create($overrides);
    }

    public function test_category_root_is_reachable(): void
    {
        $this->get('/admin/categories')->assertStatus(200);
    }

    public function test_index_lists_categories(): void
    {
        $cats = $this->makeCategories(3);

        $res = $this->get(route('admin.categories.index'));

        $res->assertOk()
            ->assertViewIs('admin.categories.index')
            ->assertViewHas('categories', function ($collection) use ($cats) {
                return $collection->count() === 3 &&
                    $collection->pluck('id')->diff($cats->pluck('id'))->isEmpty();
            });

        foreach ($cats as $c) {
            $res->assertSee(e($c->name));
        }
    }

    public function test_create_displays_form(): void
    {
        $this->get(route('admin.categories.create'))
            ->assertOk()
            ->assertViewIs('admin.categories.create');
    }

    public function test_store_persists_and_redirects_with_flash(): void
    {
        $payload = ['name' => 'Summer Shoes'];

        $res = $this->post(route('admin.categories.store'), $payload);

        $res->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('success', 'Category created successfully.');

        $this->assertDatabaseHas('categories', [
            'name' => 'Summer Shoes',
            'slug' => Str::slug('Summer Shoes'),
        ]);
    }

    public function test_store_validates_name_is_required(): void
    {
        $res = $this->from(route('admin.categories.create'))
            ->post(route('admin.categories.store'), []);

        $res->assertRedirect();
        $res->assertSessionHasErrors(['name']);
        $this->assertDatabaseCount('categories', 0);
    }

    public function test_edit_displays_form(): void
    {
        $category = $this->makeCategory();

        $this->get(route('admin.categories.edit', $category))
            ->assertOk()
            ->assertViewIs('admin.categories.edit')
            ->assertViewHas('category', fn ($bound) => $bound->is($category));
    }

    public function test_update_changes_category_and_redirects_with_flash(): void
    {
        $category = $this->makeCategory(['name' => 'Old Name']);

        $res = $this->put(route('admin.categories.update', $category), [
            'name' => 'Fresh Name',
        ]);

        $res->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('success', 'Category has been updated successfully.');

        $this->assertDatabaseHas('categories', [
            'id'   => $category->id,
            'name' => 'Fresh Name',
            'slug' => Str::slug('Fresh Name'),
        ]);
    }

    public function test_update_validates_name_is_required(): void
    {
        $category = $this->makeCategory();

        $res = $this->from(route('admin.categories.edit', $category))
            ->put(route('admin.categories.update', $category), []);

        $res->assertRedirect();
        $res->assertSessionHasErrors(['name']);
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    public function test_destroy_deletes_and_redirects_with_flash(): void
    {
        $category = $this->makeCategory();

        $res = $this->delete(route('admin.categories.destroy', $category));

        $res->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('success', 'Category deleted successfully.');

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
