<?php
    
    namespace Database\Seeders;
    
    use App\Models\User;
    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\Hash;
    
    class UserSeeder extends Seeder {
        
        /**
         * Run the database seeds.
         * @return void
         */
        
        public function run () {
            User ::create ( [
                                              'country_id'  => '1',
                                              'name'        => 'Waleed Ikhlaq',
                                              'email'       => 'waleedikhlaq2@gmail.com',
                                              'password'    => Hash ::make ( 'admin' ),
                                              'mobile'      => '+923241234567',
                                              'gender'      => '1',
                                              'identity_no' => '37405-0005878-1',
                                              'dob'         => '1994-02-12',
                                          ] );
        }
    }
