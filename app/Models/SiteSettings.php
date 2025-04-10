<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class SiteSettings extends Model {
        use HasFactory;

        protected $guarded = [];
        protected $table   = 'site_settings';

        public function getSettingsAttribute ( $value ) {
            return json_decode ( $value );
        }
    }
