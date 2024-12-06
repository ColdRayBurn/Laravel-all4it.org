<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class LoginTest extends DuskTestCase
{
    public function test_user_can_login()
    {
        $password = 'qwerty';
//        $user = User::factory()->create([
//            'name' => 'name',
//            'email' => 'test@test.com',
//            'password' => bcrypt($password),
//        ]);
        $user = User::updateOrCreate(
            ['email' => 'test@test.com'],
            [
                'name' => 'name',
                'password' => bcrypt($password),
            ]
        );

        $this->browse(function (Browser $browser) use ($user, $password) {
            $browser->visit('http://localhost:8000/admin/login')
                ->assertSee('Laravel')
                ->type('input[type=email]', $user->email)
                ->type('input[type=password]', $password)
                ->press('.fi-btn')
                ->pause(1000)
                ->screenshot('test')
                ->assertSee('Инфопанель')
                ->assertSee($user->name);
        });
    }
}
