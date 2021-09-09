<?php

use App\Enums\SystemPrefix;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            "user_code" => SystemPrefix::ADMIN_USER_CODE_PREFIX. 1231231,
            "username" => "testuser",
            "email" => "test@app.com",
            "password" => makeHashedPassword("test123"),
            "status" => 1,
            "is_deleted" => 0,
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        DB::table('members')->insert([
            "first_name" => "Sunera",
            "last_name" => "Viyangoda",
            "user_code" => SystemPrefix::ADMIN_USER_CODE_PREFIX. 1231231,
            "is_store" => 0
        ]);
    }
}
