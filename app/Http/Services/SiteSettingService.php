<?php
    
    namespace App\Http\Services;
    
    use App\Models\SiteSettings;
    use Illuminate\Support\Facades\File;
    use Ramsey\Uuid\Uuid;
    
    class SiteSettingService {
        
        /**
         * --------------
         * @param $slug
         * @return mixed
         * fetch settings by slug
         * --------------
         */
        
        public function get_settings_by_slug ( $slug ) {
            return SiteSettings ::where ( [ 'slug' => $slug ] ) -> first ();
        }
        
        /**
         * --------------
         * @param $request
         * @return void
         * save site settings
         * --------------
         */
        
        public function save ( $request ) {
            // dd ( $request -> all () );
            
            $settings     = SiteSettings ::where ( [ 'slug' => 'site-settings' ] ) -> first ();
            $settingsJson = [
                'title'                         => $request -> input ( 'title' ),
                'email'                         => $request -> input ( 'email' ),
                'phone'                         => $request -> input ( 'phone' ),
                'address'                       => $request -> input ( 'address' ),
                'display_on_pdf'                => $request -> input ( 'display_on_pdf' ),
                'e_commerce'                    => $request -> input ( 'e_commerce' ),
                'pdf_footer_content'            => $request -> input ( 'pdf-footer-content' ),
                'tagline'                       => $request -> input ( 'tagline' ),
                'description'                   => $request -> input ( 'description' ),
                'facebook'                      => $request -> input ( 'facebook' ),
                'twitter'                       => $request -> input ( 'twitter' ),
                'instagram'                     => $request -> input ( 'instagram' ),
                'youtube'                       => $request -> input ( 'youtube' ),
                'pinterest'                     => $request -> input ( 'pinterest' ),
                'tiktok'                        => $request -> input ( 'tiktok' ),
                'whatsapp'                      => $request -> input ( 'whatsapp' ),
                'shipping'                      => $request -> input ( 'shipping' ),
                'courier'                       => $request -> input ( 'courier-id' ),
                'shipping_charges'              => $request -> input ( 'shipping-charges' ),
                'display_out_of_stock_products' => $request -> input ( 'display-out-of-stock-products' ),
                'display_top_categories'        => $request -> input ( 'display-top-categories' ),
                'currency'                      => $request->input('currency'),
                'reviews_enable_with_login'     => $request->input('reviews_enable_with_login'),
                'display_popup'                 => $request->input('display_popup'),
                'display_shop_banner'            => $request->input('display_shop_banner'),
                'display_shop_categories'        => $request->input('display_shop_categories'),
                'display_prices_without_login'   => $request->input('display_prices_without_login'),

            ];
            
            if ( $request -> hasFile ( 'logo' ) )
                $settingsJson[ 'logo' ] = $this -> upload_image ( $request, $settings );
            else
                $settingsJson[ 'logo' ] = optional ( $settings -> settings ) -> logo;
            
            if ( $request -> hasFile ( 'sidebar-image' ) )
                $settingsJson[ 'sidebar_image' ] = $this -> upload_sidebar_image ( $request, $settings );
            else
                $settingsJson[ 'sidebar_image' ] = optional ( $settings -> settings ) -> sidebar_image;
            
            $info = [
                'slug'     => 'site-settings',
                'settings' => json_encode ( $settingsJson )
            ];
            
            if ( !empty( $settings ) )
                $settings -> update ( $info );
            else {
                $info[ 'license_key' ] = Uuid ::uuid4 () -> toString ();
                SiteSettings ::create ( $info );
            }
        }
        
        private function upload_image ( $request, $settings ) {
            $savePath = './uploads/site-settings/logo';
            
            File ::ensureDirectoryExists ( $savePath, 0755, true );
            
            if ( $request -> hasFile ( 'logo' ) ) {
                $filenameWithExt = $request -> file ( 'logo' ) -> getClientOriginalName ();
                $filename        = pathinfo ( $filenameWithExt, PATHINFO_FILENAME );
                $extension       = $request -> file ( 'logo' ) -> getClientOriginalExtension ();
                $fileNameToStore = $filename . '-' . time () . '.' . $extension;
                return $request -> file ( 'logo' ) -> storeAs ( $savePath, $fileNameToStore );
            }
            
            if ( !empty( $settings ) )
                return $settings -> settings -> logo;
            
        }
        
        private function upload_sidebar_image ( $request, $settings ) {
            $savePath = './uploads/site-settings/logo';
            
            File ::ensureDirectoryExists ( $savePath, 0755, true );
            
            if ( $request -> hasFile ( 'sidebar-image' ) ) {
                $filenameWithExt = $request -> file ( 'sidebar-image' ) -> getClientOriginalName ();
                $filename        = pathinfo ( $filenameWithExt, PATHINFO_FILENAME );
                $extension       = $request -> file ( 'sidebar-image' ) -> getClientOriginalExtension ();
                $fileNameToStore = $filename . '-' . time () . '.' . $extension;
                return $request -> file ( 'sidebar-image' ) -> storeAs ( $savePath, $fileNameToStore );
            }
            
            if ( !empty( $settings ) )
                return $settings -> settings -> sidebar_image;
            
        }
    }
