<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    
    public function inscription()
    {
        $response = $this->postJSON('/api/register', [
            "name" => "tomura",
            "email" => "tomura@email.com",
            "password" => "tomura"
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure(['message', 'user' => ['id', 'name', 'email']]);

        $this->assertDatabaseHas('users', ['email' => 'tomura@email.com']);
    }
}
