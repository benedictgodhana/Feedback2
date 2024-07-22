<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AssignRolesToExistingUsersSeeder extends Seeder
{
    public function run()
    {
        // Define your role assignments here
        $roleAssignments = [
            'ben@gmail.com' => 'super-admin',
            'james@gmail.com 	' => 'admin',
            'test@gmail.com' => 'member',
            // Add more email-to-role assignments as needed
        ];

        foreach ($roleAssignments as $email => $roleName) {
            // Find the user by email
            $user = User::where('email', $email)->first();

            if ($user) {
                // Assign the role to the user
                $user->assignRole($roleName);
            }
        }
    }
}
