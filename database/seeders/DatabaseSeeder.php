<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::table('roles')->insert([
            'name'=>'Admin',
            'restriction'=>'1'
        ]);
        DB::table('areas')->insert([
            'area_name'=>'A1',
            'is_active'=>'1',
            'category'=>'1'
        ]);
        DB::table('areas')->insert([
            'area_name'=>'A2',
            'is_active'=>'1',
            'category'=>'1'
        ]);
        // $this->call(UsersTableSeeder::class);
    	DB::table('users')->insert([
    		'username'=>'admin',
    		'name'=>'admin',
    		
    		'password'=>'$2y$10$90s7qmS.gmubQToZKY.bvurnp1e7PdnUp7yXnGljqdUFHqx36Du2i',
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
    }
}
