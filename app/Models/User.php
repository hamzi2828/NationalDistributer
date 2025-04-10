<?php
     
    namespace App\Models;
    
    // use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Casts\Attribute;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Sanctum\HasApiTokens;
    use Illuminate\Database\Eloquent\SoftDeletes;
    
    class User extends Authenticatable {
        use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
        
        protected $guarded = [];
        
        protected $hidden = [
            'password',
            'remember_token',
        ];
        
        protected $casts = [
            'email_verified_at' => 'datetime',
        ];
        
        public function getNameAttribute ( $value ): string {
            return str () -> title ( $value );
        }
        
        public function getGenderAttribute ( $value ): string {
            return str () -> title ( $value == '1' ? 'Male' : 'Female' );
        }
        
        public function getStatusAttribute ( $value ): string {
            return str () -> title ( $value == '1' ? 'Active' : 'Inactive' );
        }
        
        public function roles () {
            return $this -> hasMany ( UserRole::class );
        }
        
        public function country () {
            return $this -> belongsTo ( Country::class );
        }
        
        public function branch () {
            return $this -> belongsTo ( Branch::class );
        }
        
        public function logs () {
            return $this -> morphMany ( Log::class, 'logable' );
        }
        
        public function user_roles () {
            $this -> load ( [ 'roles.role' ] );
            $roles = array ();
            
            if ( count ( $this -> roles ) > 0 ) {
                foreach ( $this -> roles as $userRoles ) {
                    if ( !empty( $userRoles -> role ) ) {
                        array_push ( $roles, $userRoles -> role -> slug );
                    }
                }
            }
            return $roles = array_values ( array_unique ( $roles, SORT_REGULAR ) );
        }
        
        public function get_user_roles () {
            $this -> load ( [ 'roles.role' ] );
            $roles = array ();
            
            if ( count ( $this -> roles ) > 0 ) {
                foreach ( $this -> roles as $userRoles ) {
                    if ( !empty( $userRoles -> role ) ) {
                        array_push ( $roles, $userRoles -> role -> title );
                    }
                }
            }
            return $roles = array_values ( array_unique ( $roles, SORT_REGULAR ) );
        }
        
        public function permissions () {
            $this -> load ( [ 'roles.role.permission' ] );
            $permissions = array ();
            
            if ( count ( $this -> roles ) > 0 ) {
                foreach ( $this -> roles as $roles ) {
                    if ( !empty( $roles -> role ) && !empty( $roles -> role -> permission ) ) {
                        if ( count ( $roles -> role -> permission -> permission ) > 0 ) {
                            foreach ( $roles -> role -> permission -> permission as $permission ) {
                                array_push ( $permissions, $permission );
                            }
                        }
                    }
                }
            }
            return $permissions = array_values ( array_unique ( $permissions, SORT_REGULAR ) );
        }
        
        public function customers () {
            return $this -> hasMany ( UserAccountHead::class );
        }
        
    }
