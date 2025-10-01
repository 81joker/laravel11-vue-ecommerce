<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Color;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ColorTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_color(): void
    {
        $response = $this->get('/admin/colors');

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

    public function test_color_index(): void
    {
        $this->signIn();
        $cats = Color::factory()->count(3)->create();

        $res = $this->get(route('admin.colors.index'));
        $res->assertStatus(200);

        $res->assertOk()
            ->assertViewIs('admin.colors.index')
            ->assertViewHas('colors', function ($collection) use ($cats) {
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

        $this->get(route('admin.colors.create'))
            ->assertOk()
            ->assertViewIs('admin.colors.create');
    }

    public function test_store_persists_a_new_color_and_redirects_with_flash()
    {
        $this->signIn();

        $payload = ['name' => 'Summer Shoes'];

        $res = $this->post(route('admin.colors.store'), $payload);

        $res->assertRedirect(route('admin.colors.index'))
            ->assertSessionHas('success', 'Color created successfully.');

        $this->assertDatabaseHas('colors', [
            'name' => 'Summer Shoes',
        ]);
    }

    public function test_store_fails_validation_when_name_is_missing()
    {
        $this->signIn();

        $res = $this->from(route('admin.colors.create'))
            ->post(route('admin.colors.store'), []);

        $res->assertRedirect(); // back
        $res->assertSessionHasErrors(['name']);
        $this->assertDatabaseCount('colors', 0);
    }

    public function test_edit_displays_the_edit_form()
    {
        $this->signIn();

        $color = Color::factory()->create();

        $this->get(route('admin.colors.edit', $color))
            ->assertOk()
            ->assertViewIs('admin.colors.edit')
            ->assertViewHas('color', function ($bound) use ($color) {
                return $bound->is($color);
            });
    }

    public function test_update_changes_the_color_and_redirects_with_flash()
    {
        $this->signIn();

        $color = Color::factory()->create(['name' => 'Old Name']);
        $payload  = ['name' => 'Fresh Name'];

        $res = $this->put(route('admin.colors.update', $color), $payload);

        $res->assertRedirect(route('admin.colors.index'))
            ->assertSessionHas('success', 'Color has been updated successfully.');

        $this->assertDatabaseHas('colors', [
            'id'   => $color->id,
            'name' => 'Fresh Name',
        ]);
    }

    public function test_update_fails_validation_when_name_is_missing()
    {
        $this->signIn();

        $color = Color::factory()->create();

        $res = $this->from(route('admin.colors.edit', $color))
            ->put(route('admin.colors.update', $color), []);

        $res->assertRedirect();
        $res->assertSessionHasErrors(['name']);
        $this->assertDatabaseHas('colors', ['id' => $color->id]); // unchanged still exists
    }

    public function test_destroy_deletes_the_color_and_redirects_with_flash()
    {
        $this->signIn();

        $color = Color::factory()->create();

        $res = $this->delete(route('admin.colors.destroy', $color));

        $res->assertRedirect(route('admin.colors.index'))
            ->assertSessionHas('success', 'Color deleted successfully.');

        $this->assertDatabaseMissing('colors', ['id' => $color->id]);
    }
}
