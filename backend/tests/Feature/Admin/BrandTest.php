<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BrandTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_brand(): void
    {
        $response = $this->get('/admin/brands');

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

    public function test_brand_index(): void
    {
        $this->signIn();
        $cats = Brand::factory()->count(3)->create();

        $res = $this->get(route('admin.brands.index'));
        $res->assertStatus(200);

        $res->assertOk()
            ->assertViewIs('admin.brands.index')
            ->assertViewHas('brands', function ($collection) use ($cats) {
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

        $this->get(route('admin.brands.create'))
            ->assertOk()
            ->assertViewIs('admin.brands.create');
    }

    public function test_store_persists_a_new_brand_and_redirects_with_flash()
    {
        $this->signIn();

        $payload = ['name' => 'Summer Shoes'];

        $res = $this->post(route('admin.brands.store'), $payload);

        $res->assertRedirect(route('admin.brands.index'))
            ->assertSessionHas('success', 'Brand created successfully.');

        $this->assertDatabaseHas('brands', [
            'name' => 'Summer Shoes',
            'slug' => Str::slug('Summer Shoes'),
        ]);
    }

    public function test_store_fails_validation_when_name_is_missing()
    {
        $this->signIn();

        $res = $this->from(route('admin.brands.create'))
            ->post(route('admin.brands.store'), []);

        $res->assertRedirect(); // back
        $res->assertSessionHasErrors(['name']);
        $this->assertDatabaseCount('brands', 0);
    }

    public function test_edit_displays_the_edit_form()
    {
        $this->signIn();

        $brand = Brand::factory()->create();

        $this->get(route('admin.brands.edit', $brand))
            ->assertOk()
            ->assertViewIs('admin.brands.edit')
            ->assertViewHas('brand', function ($bound) use ($brand) {
                return $bound->is($brand);
            });
    }

    public function test_update_changes_the_brand_and_redirects_with_flash()
    {
        $this->signIn();

        $brand = Brand::factory()->create(['name' => 'Old Name']);
        $payload  = ['name' => 'Fresh Name'];

        $res = $this->put(route('admin.brands.update', $brand), $payload);

        $res->assertRedirect(route('admin.brands.index'))
            ->assertSessionHas('success', 'Brand has been updated successfully.');

        $this->assertDatabaseHas('brands', [
            'id'   => $brand->id,
            'name' => 'Fresh Name',
            'slug' => Str::slug('Fresh Name'),
        ]);
    }

    public function test_update_fails_validation_when_name_is_missing()
    {
        $this->signIn();

        $brand = Brand::factory()->create();

        $res = $this->from(route('admin.brands.edit', $brand))
            ->put(route('admin.brands.update', $brand), []);

        $res->assertRedirect();
        $res->assertSessionHasErrors(['name']);
        $this->assertDatabaseHas('brands', ['id' => $brand->id]); // unchanged still exists
    }

    public function test_destroy_deletes_the_brand_and_redirects_with_flash()
    {
        $this->signIn();

        $brand = Brand::factory()->create();

        $res = $this->delete(route('admin.brands.destroy', $brand));

        $res->assertRedirect(route('admin.brands.index'))
            ->assertSessionHas('success', 'Brand deleted successfully.');

        $this->assertDatabaseMissing('brands', ['id' => $brand->id]);
    }
}
