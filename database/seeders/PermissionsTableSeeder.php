<?php
namespace Database\Seeders;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name'          => 'Admin',
                'role_id'       => 1,
                'is_active'     => 1,
                'email'         => 'admin@gmail.com',
                'password'      => bcrypt('12345678'),
                'created_at'    => Carbon::now()->toDateTimeString(),
                'updated_at'    => Carbon::now()->toDateTimeString(),
            ]
        ];
        
        DB::table('users')->insert($users);
    }
}
