<?php
    
    namespace App\Http\Services;
    
    use App\Models\HomeSetting;
    use App\Models\SiteSettings;
    use Illuminate\Support\Facades\File;
    use Intervention\Image\ImageManager;
    use Ramsey\Uuid\Uuid;
    
    class HomeSettingService {
        
        public function save($request) {

            // dd($request->all());
            // Retrieve the first HomeSetting record or create a new one
            $homeSettings = HomeSetting::first();
        
            // Check if there is no existing HomeSetting record
            if (!$homeSettings) {
                $homeSettings = HomeSetting::create([
                    'banner_1' => $this->upload_image($request, 'banner-1'),
                    'banner_2' => $this->upload_image($request, 'banner-2'),
                    'banner_3' => $this->upload_image($request, 'banner-3'),
                    'banner_4' => $this->upload_image($request, 'banner-4'),
                    'newsletter_title' => $request->input('newsletter_title'),
                    'newsletter_subtitle' => $request->input('newsletter_subtitle'),
                    'newsletter_description' => $request->input('newsletter_description'),
                    'newsletter_image' => $this->upload_image($request, 'newsletter_image'),
                    'shop_banner_subtitle' => $request->input('shop_banner_subtitle'),
                    'shop_banner_title' => $request->input('shop_banner_title'),
                    'shop_banner_image' => $this->upload_image($request, 'shop_banner_image'),
                    'shop_banner_link' => $request->input('shop_banner_link'),
                    'shop_banner_button_text' => $request->input('shop_banner_button_text'),
                ]);
            } else {
                // Update existing HomeSetting record
                if ($request->hasFile('banner-1')) {
                    $homeSettings->banner_1 = $this->upload_image($request, 'banner-1');
                }
        
                if ($request->hasFile('banner-2')) {
                    $homeSettings->banner_2 = $this->upload_image($request, 'banner-2');
                }
        
                if ($request->hasFile('banner-3')) {
                    $homeSettings->banner_3 = $this->upload_image($request, 'banner-3');
                }
        
                if ($request->hasFile('banner-4')) {
                    $homeSettings->banner_4 = $this->upload_image($request, 'banner-4');
                }
        
                if ($request->hasFile('newsletter_image')) {
                    $homeSettings->newsletter_image = $this->upload_image($request, 'newsletter_image');
                }
        
                if ($request->hasFile('shop_banner_image')) {
                    $homeSettings->shop_banner_image = $this->upload_image($request, 'shop_banner_image');
                }
        
                $homeSettings->shop_banner_subtitle = $request->input('shop_banner_subtitle');
                $homeSettings->shop_banner_title = $request->input('shop_banner_title');
                $homeSettings->shop_banner_link = $request->input('shop_banner_link');
                $homeSettings->shop_banner_button_text = $request->input('shop_banner_button_text');

                $homeSettings->newsletter_title = $request->input('newsletter_title');
                $homeSettings->newsletter_subtitle = $request->input('newsletter_subtitle');
                $homeSettings->newsletter_description = $request->input('newsletter_description');
        
                // Save the changes
                $homeSettings->save();
            }
        }
        
        
        private function upload_image ( $request, $fileName ): string {
            $savePath = './uploads/hom-settings/banners/';
            $path     = '';
            
            File ::ensureDirectoryExists ( $savePath, 0755, true );
            
            if ( $request -> hasFile ( $fileName ) ) {
                $filenameWithExt = $request -> file ( $fileName ) -> getClientOriginalName ();
                $filename        = pathinfo ( $filenameWithExt, PATHINFO_FILENAME );
                $extension       = $request -> file ( $fileName ) -> getClientOriginalExtension ();
                $fileNameToStore = $filename . '-' . time () . '.' . $extension;
                $path            = $request -> file ( $fileName ) -> storeAs ( $savePath, $fileNameToStore );
                $image           = ImageManager ::imagick () -> read ( $path );
                $image -> scale ( width: 600 );
                $image -> save ( $path );
                return asset ( $path );
            }
            return $path;
        }
    }
