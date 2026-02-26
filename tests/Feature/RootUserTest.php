<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RootUserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RootUserSeeder::class);
    }

    public function test_root_user_exists()
    {
        $this->assertDatabaseHas('users', [
            'email' => 'root@kashmos.com',
            'is_root' => true,
        ]);
    }

    public function test_root_user_cannot_be_deleted()
    {
        $root = \App\Models\User::where('email', 'root@kashmos.com')->first();
        $root->delete();

        $this->assertDatabaseHas('users', ['email' => 'root@kashmos.com']);
    }

    public function test_root_user_email_is_immutable()
    {
        $root = \App\Models\User::where('email', 'root@kashmos.com')->first();
        $root->email = 'changed@kashmos.com';

        $this->actingAs($root);
        $root->save();

        $root->refresh();
        $this->assertEquals('root@kashmos.com', $root->email);
    }

    public function test_root_user_can_change_own_password()
    {
        $root = \App\Models\User::where('email', 'root@kashmos.com')->first();
        $oldPassword = $root->password;

        $this->actingAs($root);
        $root->password = \Illuminate\Support\Facades\Hash::make('NewPassword123!');
        $root->save();

        $root->refresh();
        $this->assertNotEquals($oldPassword, $root->password);
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('NewPassword123!', $root->password));
    }

    public function test_root_user_cannot_be_edited_by_others()
    {
        $root = \App\Models\User::where('email', 'root@kashmos.com')->first();
        $otherUser = \App\Models\User::factory()->create(['is_root' => false]);

        $this->actingAs($otherUser);

        $root->name = 'Hacked Name';
        $root->save();

        $root->refresh();
        $this->assertNotEquals('Hacked Name', $root->name);
    }

    public function test_root_is_root_flag_cannot_be_changed()
    {
        $root = \App\Models\User::where('email', 'root@kashmos.com')->first();
        $this->actingAs($root);

        $root->is_root = false;
        $root->save();

        $root->refresh();
        $this->assertTrue($root->is_root);
    }
}
