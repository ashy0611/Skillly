<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SkillSeeder::class,           // Seed all skills first
            CareerDomainSeeder::class,   // Seed career domains next
            CareerSkillRuleSeeder::class, // Seed rules last
        ]);
    }
}
