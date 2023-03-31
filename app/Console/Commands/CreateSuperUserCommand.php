<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateSuperUserCommand extends Command
{
    protected $signature = 'create:super-user {email} {password}';

    protected $description = 'Create a superuser';

    public function handle(): void
    {
        if(User::where('is_super_user', true)->exists()) {
            $this->error('Super user already exists');
            return;
        }

        if(User::where('email', $this->argument('email'))->exists()) {
            $this->error('User with this email already exists');
            return;
        }

        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = new User();
        $user->name = "Super User";
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->is_super_user = true;

        $user->save();

        $this->line('Super user created');

    }
}
