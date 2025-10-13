<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Subscriber;
use App\User;

class RemoveSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:remove {user_id : The ID of the user whose subscription will be removed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all subscriber data for a user and change their role to registered';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');

        $user = User::find($userId);

        if (!$user) {
            $this->error("User with ID {$userId} not found.");
            return 1;
        }

        // Delete all subscriber records for this user
        $deleted = Subscriber::where('user_id', $userId)->delete();

        // Update the user role
        $user->role = 'registered';
        $user->save();

        $this->info("Removed {$deleted} subscriber record(s) and updated user ID {$userId} role to 'registered'.");

        return 0;
    }
}
