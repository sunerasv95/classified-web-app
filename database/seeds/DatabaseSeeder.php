<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategorySeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(PricingOptionSeeder::class);
        $this->call(ListingSeeder::class);
        $this->call(ListingImageSeeder::class);
        $this->call(SkillLevelSeeder::class);
        $this->call(FinTypeSeeder::class);
        $this->call(WaveTypeSeeder::class);
        $this->call(MaterialSeeder::class);
        $this->call(MemberTypeSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RolePermissionSeeder::class);
    }
}
