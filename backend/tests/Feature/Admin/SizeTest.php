<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Size;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SizeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_size(): void
    {
        $response = $this->get('/admin/sizes');

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

    public function test_size_index(): void
    {
        $this->signIn();
        $cats = Size::factory()->count(3)->create();

        $res = $this->get(route('admin.sizes.index'));
        $res->assertStatus(200);

        $res->assertOk()
            ->assertViewIs('admin.sizes.index')
            ->assertViewHas('sizes', function ($collection) use ($cats) {
                return $collection->count() === 3 &&
                    $collection->pluck('id')->diff($cats->pluck('id'))->isEmpty();
            });
        foreach ($cats as $c) {
            $res->assertSee(e($c->name));
        }
    }

    public function test_create_displays_the_create_form()
    {
        $this->signIn();

        $this->get(route('admin.sizes.create'))
            ->assertOk()
            ->assertViewIs('admin.sizes.create');
    }

    public function test_store_persists_a_new_size_and_redirects_with_flash()
    {
        $this->signIn();

        $payload = ['name' => 'Summer Shoes'];

        $res = $this->post(route('admin.sizes.store'), $payload);

        $res->assertRedirect(route('admin.sizes.index'))
            ->assertSessionHas('success', 'Size created successfully.');

        $this->assertDatabaseHas('sizes', [
            'name' => 'Summer Shoes',
        ]);
    }

    public function test_store_fails_validation_when_name_is_missing()
    {
        $this->signIn();

        $res = $this->from(route('admin.sizes.create'))
            ->post(route('admin.sizes.store'), []);

        $res->assertRedirect(); // back
        $res->assertSessionHasErrors(['name']);
        $this->assertDatabaseCount('sizes', 0);
    }

    public function test_edit_displays_the_edit_form()
    {
        $this->signIn();

        $size = Size::factory()->create();

        $this->get(route('admin.sizes.edit', $size))
            ->assertOk()
            ->assertViewIs('admin.sizes.edit')
            ->assertViewHas('size', function ($bound) use ($size) {
                return $bound->is($size);
            });
    }

    public function test_update_changes_the_size_and_redirects_with_flash()
    {
        $this->signIn();

        $size = Size::factory()->create(['name' => 'Old Name']);
        $payload  = ['name' => 'Fresh Name'];

        $res = $this->put(route('admin.sizes.update', $size), $payload);

        $res->assertRedirect(route('admin.sizes.index'))
            ->assertSessionHas('success', 'Size has been updated successfully.');

        $this->assertDatabaseHas('sizes', [
            'id'   => $size->id,
            'name' => 'Fresh Name',
        ]);
    }

    public function test_update_fails_validation_when_name_is_missing()
    {
        $this->signIn();

        $size = Size::factory()->create();

        $res = $this->from(route('admin.sizes.edit', $size))
            ->put(route('admin.sizes.update', $size), []);

        $res->assertRedirect();
        $res->assertSessionHasErrors(['name']);
        $this->assertDatabaseHas('sizes', ['id' => $size->id]); // unchanged still exists
    }

    public function test_destroy_deletes_the_size_and_redirects_with_flash()
    {
        $this->signIn();

        $size = Size::factory()->create();

        $res = $this->delete(route('admin.sizes.destroy', $size));

        $res->assertRedirect(route('admin.sizes.index'))
            ->assertSessionHas('success', 'Size deleted successfully.');

        $this->assertDatabaseMissing('sizes', ['id' => $size->id]);
    }
}
