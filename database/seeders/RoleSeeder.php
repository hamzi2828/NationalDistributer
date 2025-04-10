<?php
    
    namespace Database\Seeders;
    
    use App\Models\Role;
    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    
    class RoleSeeder extends Seeder {
        
        /**
         * Run the database seeds.
         * @return void
         */
        
        public function run () {
            Role ::create ( [
                                'user_id'    => 1,
                                'title'      => 'Admin',
                                'slug'       => 'admin',
                                'can_delete' => '0'
                            ] );
        }
    }
