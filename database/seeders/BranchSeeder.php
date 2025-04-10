<?php
    
    namespace Database\Seeders;
    
    use App\Models\Branch;
    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    
    class BranchSeeder extends Seeder {
        
        /**
         * Run the database seeds.
         * @return void
         */
        
        public function run () {
            Branch ::create ( [
                                  'user_id'           => 1,
                                  'branch_manager_id' => 1,
                                  'country_id'        => 1,
                                  'code'              => 'MB',
                                  'name'              => 'Main Branch',
                                  'landline'          => '0000000000',
                                  'mobile'            => '00000000000',
                                  'address'           => 'Street X, Floor Y',
                              ] );
        }
    }
