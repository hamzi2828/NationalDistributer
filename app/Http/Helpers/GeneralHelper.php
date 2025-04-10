<?php
    
    namespace App\Http\Helpers;
    
    class GeneralHelper {
        
        public function generateRandomString ( $length = 8 ) {
            $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen ( $characters );
            $randomString     = '';
            for ( $i = 0; $i < $length; $i++ ) {
                $randomString .= $characters[ rand ( 0, $charactersLength - 1 ) ];
            }
            return $randomString;
        }
        
        public function get_voucher_title ( $voucher_no ) {
            $voucher = explode ( '-', $voucher_no );
            
            return match ( strtolower ( $voucher[ 0 ] ) ) {
                'cpv' => 'Cash Payment Voucher',
                'crv' => 'Cash Receipt Voucher',
                'bpv' => 'Bank Payment Voucher',
                'brv' => 'Bank Receipt Voucher',
                'jv'  => 'General Voucher',
            };
        }
        
        public function format_currency ( $num ) {
            
            if ( $num < 1 )
                return number_format ( $num, 2 );
            
            if ( $num > 1000 ) {
                
                $x               = round ( $num );
                $x_number_format = number_format ( $x );
                $x_array         = explode ( ',', $x_number_format );
                $x_parts         = array (
                    'k',
                    'm',
                    'b',
                    't'
                );
                $x_count_parts   = count ( $x_array ) - 1;
                $x_display       = $x;
                $x_display       = $x_array[ 0 ] . ( (int)$x_array[ 1 ][ 0 ] !== 0 ? '.' . $x_array[ 1 ][ 0 ] : '' );
                $x_display       .= $x_parts[ $x_count_parts - 1 ];
                
                return $x_display;
                
            }
            
            return $num;
        }
        
        public function format_date ( $date ): string {
            return date ( 'd-m-Y', strtotime ( $date ) );
        }
        
        public function format_date_time ( $date ): string {
            return date ( 'd-m-Y h:i A', strtotime ( $date . " +5 hours" ) );
        }
        
    }