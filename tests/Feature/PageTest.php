<?php

namespace Tests\Feature;

use Jano\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use UserDatabaseSeeder;

class PageTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test home page.
     */
    public function testHomePage()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertDontSeeText(__('system.account'));

        $this->seed(UserDatabaseSeeder::class);

        $user = User::first();
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
        $response->assertSee(__('system.account'));
    }

    /**
     * Test login page.
     */
    public function testLoginPage()
    {
        $response = $this->get('login');
        $response->assertStatus(200);
        $response->assertSeeText(__('system.login'));

        $this->seed(UserDatabaseSeeder::class);

        $user = User::first();
        $response = $this->actingAs($user)->get('login');
        $response->assertRedirect('/');
    }
}
