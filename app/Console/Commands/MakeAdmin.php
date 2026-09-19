<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeAdmin extends Command
{
    protected $signature = 'app:make-admin {email}';
    protected $description = 'Promote a user to admin by email';

    public function handle(): int
    {
        $user = User::where('email', $this->argument('email'))->first();

        if (! $user) {
            $this->error('No user found with that email. Register an account first.');
            return self::FAILURE;
        }

        $user->update(['is_admin' => true]);
        $this->info("{$user->email} is now an admin.");
        return self::SUCCESS;
    }
}
