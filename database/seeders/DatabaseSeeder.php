<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('roles')->insert([
            'name'=>'Admin',
            'restriction'=>'1'
        ]);
        DB::table('areas')->insert([
            'name'=>'A1',
            'is_active'=>'1',
            'category'=>'1'
        ]);
        DB::table('areas')->insert([
            'name'=>'A2',
            'is_active'=>'1',
            'category'=>'1'
        ]);
        // $this->call(UsersTableSeeder::class);
    	DB::table('users')->insert([
    		'username'=>'admin',
    		'name'=>'bulinaw',
    		
    		'password'=>'$2y$10$su0u0tWHzbhL75ER.xctROZfP6XUUFE.ug0U6OF91O/mZWLuOcINa',
    		'role_id'=>'1',
    		'is_active'=>'1',
    		'remember_token'=>'6a2MXPNSn9YzHGJZSgQ9DSdLH9AtseeHr7NjGsV7IEe5KdW2bJKBlKFv6OK9'
        ]);
        DB::table('users')->insert([
            'username'=>'potchie',
            'name'=>'potchie',
            
            'password'=>'$2y$10$qYho59a6LcfQRrTV37KukOCgLgrfrqi4a3M6rfYrZXiolPCOx0JxO',
            'role_id'=>'1',
            'is_active'=>'1',
            'remember_token'=>'6a2MXPNSn9YzHGJZSgQ9DSdLH9AtseeHr7NjGsV7IEe5KdW2bJKBlKFv6OK9'
        ]);
        \App\Models\Client::factory(20)->create();
    }
}
