<?php
    
    namespace App\Providers;
    
    use App\Models\Account;
    use App\Models\AccountRole;
    use App\Models\AccountType;
    use App\Models\Attribute;
    use App\Models\Branch;
    use App\Models\Category;
    use App\Models\Country;
    use App\Models\Customer;
    use App\Models\Issuance;
    use App\Models\Manufacturer;
    use App\Models\Permission;
    use App\Models\Product;
    use App\Models\Role;
    use App\Models\Sale;
    use App\Models\SaleProducts;
    use App\Models\Stock;
    use App\Models\Term;
    use App\Models\User;
    use App\Models\UserRole;
    use App\Models\Vendor;
    use App\Observers\AccountObserver;
    use App\Observers\AccountRoleObserver;
    use App\Observers\AccountTypeObserver;
    use App\Observers\AttributeObserver;
    use App\Observers\BranchObserver;
    use App\Observers\CategoryObserver;
    use App\Observers\CountryObserver;
    use App\Observers\CustomerObserver;
    use App\Observers\IssuanceObserver;
    use App\Observers\ManufacturerObserver;
    use App\Observers\PermissionObserver;
    use App\Observers\ProductObserver;
    use App\Observers\RoleObserver;
    use App\Observers\SaleObserver;
    use App\Observers\SaleProductObserver;
    use App\Observers\StockObserver;
    use App\Observers\TermObserver;
    use App\Observers\UserObserver;
    use App\Observers\UserRoleObserver;
    use App\Observers\VendorObserver;
    use Illuminate\Auth\Events\Registered;
    use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
    use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
    use Illuminate\Support\Facades\Event;
    
    class EventServiceProvider extends ServiceProvider {
        
        /**
         * The event to listener mappings for the application.
         * @var array<class-string, array<int, class-string>>
         */
        
        protected $listen = [
            Registered::class => [
                SendEmailVerificationNotification::class,
            ],
        ];
        
        /**
         * Register any events for your application.
         * @return void
         */
        
        public function boot () {
            Branch ::observe ( BranchObserver::class );
            Country ::observe ( CountryObserver::class );
            Permission ::observe ( PermissionObserver::class );
            Role ::observe ( RoleObserver::class );
            User ::observe ( UserObserver::class );
            UserRole ::observe ( UserRoleObserver::class );
            Category ::observe ( CategoryObserver::class );
            Attribute ::observe ( AttributeObserver::class );
            Term ::observe ( TermObserver::class );
            Manufacturer ::observe ( ManufacturerObserver::class );
            Product ::observe ( ProductObserver::class );
            Vendor ::observe ( VendorObserver::class );
            Stock ::observe ( StockObserver::class );
            AccountType ::observe ( AccountTypeObserver::class );
            Account ::observe ( AccountObserver::class );
            AccountRole ::observe ( AccountRoleObserver::class );
            Customer ::observe ( CustomerObserver::class );
            Sale ::observe ( SaleObserver::class );
            SaleProducts ::observe ( SaleProductObserver::class );
            Issuance ::observe ( IssuanceObserver::class );
        }
        
        /**
         * Determine if events and listeners should be automatically discovered.
         * @return bool
         */
        
        public function shouldDiscoverEvents () {
            return false;
        }
    }
