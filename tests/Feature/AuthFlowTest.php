<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\SeedsRoles;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;
    use SeedsRoles;

    public function test_registration_creates_a_customer_and_redirects_to_dashboard(): void
    {
        $this->seedRoles();

        $response = $this->post('/register', [
            'name' => 'Jane Customer',
            'email' => 'jane@example.com',
            'phone' => '12345',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'jane@example.com']);
    }
}
