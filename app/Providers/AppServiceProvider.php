<?php

    namespace App\Providers;

    use App\Models\SiteSettings;
    use Illuminate\Support\Facades\View;
    use Illuminate\Support\ServiceProvider;

    class AppServiceProvider extends ServiceProvider {

        /**
         * Register any application services.
         * @return void
         */

        public function register () {
            //
        }

        /**
         * Bootstrap any application services.
         * @return void
         */

        public function boot () {
            $settings = SiteSettings ::where ( [ 'slug' => 'site-settings' ] ) -> first ();
            View ::composer ( 'invoices.*', function ( $view ) use ( $settings ) {
                $view -> with ( 'settings', $settings );
                $view -> with ( 'pdf_header', view ( 'partials.pdf.header', compact ( 'settings' ) ) );
                $view -> with ( 'pdf_footer', view ( 'partials.pdf.footer', compact ( 'settings' ) ) );
            } );
        }
    }
