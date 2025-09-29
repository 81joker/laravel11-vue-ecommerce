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
            $res->assertSee(e($c->name));
        }
    }

       public function test_create_displays_the_create_form()
    {
        $this->signIn();

        $this->get(route('admin.categories.create'))
             ->assertOk()
             ->assertViewIs('admin.categories.create');
    }

}
