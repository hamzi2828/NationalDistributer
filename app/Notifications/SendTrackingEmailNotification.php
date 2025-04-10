<?php
    
    namespace App\Notifications;
    
    use App\Http\Services\SiteSettingService;
    use App\Models\Courier;
    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Notifications\Messages\MailMessage;
    use Illuminate\Notifications\Notification;
    
    class SendTrackingEmailNotification extends Notification {
        use Queueable;
        
        public object $sale;
        
        public function __construct ( $sale ) {
            $this -> sale = $sale;
        }
        
        public function via ( $notifiable ) {
            return [ 'mail' ];
        }
        
        public function toMail ( $notifiable ) {
            $settings   = ( new SiteSettingService() ) -> get_settings_by_slug ( 'site-settings' );
            $courier_id = optional ( $settings -> settings ) -> coureir;
            $courier    = Courier ::find ( $this -> sale -> courier_id );
            
            return ( new MailMessage )
                -> cc ( 'waleedikhlaq2@gmail.com' )
                -> greeting ( 'Your shipment is on the way.' )
                -> line ( 'We are glad to let you know that your shipment has been dispatched and will be delivered you soon. Please keep ready the cash as per invoice.' )
                -> line ( 'Your tracking id is: ' . $this -> sale -> tracking_no )
                -> action ( 'Track Shipment', $courier -> tracking_link . '/' . $this -> sale -> tracking_no );
        }
        
        /**
         * Get the array representation of the notification.
         *
         * @param mixed $notifiable
         * @return array
         */
        public function toArray ( $notifiable ) {
            return [
                //
            ];
        }
    }
