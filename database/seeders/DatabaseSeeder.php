<?php

    namespace Database\Seeders;

    // use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use App\Models\User;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\Hash;

    class DatabaseSeeder extends Seeder {

        /**
         * Seed the application's database.
         * @return void
         */

        public function run () {
            $this -> call ( [
                                CountrySeeder::class,
                                UserSeeder::class,
                                BranchSeeder::class,
                                RoleSeeder::class,
                                UserRoleSeeder::class,
                                MonthSeeder::class,
                                SiteSettingSeeder::class
                            ] );
        }
    }
