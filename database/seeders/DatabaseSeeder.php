<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create 10 users
        //\App\Models\User::factory(10)->create();

        // Copy the default image to the storage folder
        //$imagePath = public_path('default-user-image.jpg');
        //$storagePath = storage_path('app/public/images/default-user-image.jpg');
        //File::copy($imagePath, $storagePath);

        // Create a user with the default image
        $password = 'password';
        
        \App\Models\User::factory()->create([
            'first_name' => 'Anchor',
            'middle_name' => '',
            'last_name' => 'Point',
            'number' => '9867253425',
            'address' => 'Rabhibhawan',
            'email' =>'anchorpoint@gmail.com',
            'password' => $password,
            'position' => 'manager',
            'user_role' => 'admin',
            'image' => 'default-user-image.jpg',
        ]);

        \App\Models\User::factory()->create([
            'first_name' => 'Point',
            'middle_name' => '',
            'last_name' => 'Anchor',
            'number' => '9867253825',
            'address' => 'Kalanki',
            'email' =>'anchorpoint123@gmail.com',
            'password' => $password,
            'position' => 'hr',
            'user_role' => 'superadmin',
            'image' => 'default-user-image.jpg',
        ]);

        // Call other seeders
        $this->call(LeaveCategorySeeder::class);
        $this->call(leave_calendersTableSeeder::class);
        
    }
}
