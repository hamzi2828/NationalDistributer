<?php

    namespace Database\Seeders;

    use App\Models\SiteSettings;
    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use Ramsey\Uuid\Uuid;

    class SiteSettingSeeder extends Seeder {

        /**
         * Run the database seeds.
         * @return void
         */
        public function run () {
            $settings = SiteSettings ::where ( [ 'slug' => 'site-settings' ] ) -> first ();

            if ( empty( $settings ) ) {
                $info = [
                    'slug'        => 'site-settings',
                    'settings'    => json_encode ( [
                                                       'title'          => 'Inventory Management System',
                                                       'email'          => 'youremail@mail.com',
                                                       'phone'          => '+123 456 789',
                                                       'address'        => 'Islamabad, Pakistan',
                                                       'display_on_pdf' => '0',
                                                       'logo'           => null,
                                                   ] ),
                    'license_key' => Uuid ::uuid4 () -> toString ()
                ];

                SiteSettings ::create ( $info );
            }
        }
    }
