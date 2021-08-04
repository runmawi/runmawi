<?php
namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Permissions\HasPermissionsTrait;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use  HasApiTokens,Notifiable;
    
    use HasPermissionsTrait; //Import The Trait
    
    use Billable;

    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
    
    private $token;
    
    public function __construct($data = null)
    {
        $this->token = $data;
    }
    
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
//	protected $fillable = [ 'username', 'active', 'email', 'terms','ccode', 'name', 'mobile', 'referrer_id','avatar','terms','stripe_active','sub_admin', 'password', 'role', 'status', 'disabled', 'activation_code'];
    
    protected $fillable = ['username', 'active', 'email', 'name', 'paypal_id', 'subscription_start', 'coupon_expired', 'payment_type', 'paypal_end_at', 'ccode', 'mobile','avatar','terms','stripe_active','sub_admin','referral_token', 'password', 'role', 'status', 'disabled', 'activation_code','provider', 'provider_id'];
   
        /**
        *The attributes excluded from the model's JSON form.
        ** @var array
        */
	protected $hidden = ['password', 'remember_token'];

	protected $dates = ['trial_ends_at', 'subscription_ends_at'];

	public static $rules = array('username' => 'required|unique:users|min:3',
						        'email' => 'required|email|unique:users',
						        'password' => 'required|confirmed|min:3'
						    );

	public static $update_rules = array('username' => 'unique:users|min:3',
						        'email' => 'email|unique:users'
						    );
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['referral_link'];
    
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    
    
    /**
     * Get the user's referral link.
     *
     * @return string
     */
    public function getReferralLinkAttribute()
    {
        return $this->referral_link = route('signup', ['ref' => $this->referral_link]);
    }
    
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime', 
        'mobile_verified_at' => 'datetime',
    ];
    
    
    
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id', 'id');
    }
    
  
    
    /**
     * A user has many referrals.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    
    public function referrals()
    {
        return $this->hasMany(User::class, 'referrer_id', 'id');
    }  
    public function used_referrals()
    {
        return $this->hasMany(User::class, 'referrer_id', 'id');
    }
    
     
    public function coupon_purchased()
    {
        return $this->hasMany(CouponPurchase, 'ref_id', 'id');
    }
    

    
    public function purchesed()
    {
        return $this->hasMany(User::class,'ref_id');
    }
    
    public function sendPasswordResetNotification($token)
        {
            $this->notify(new ResetPasswordNotification($token));
        }
    
    public function subs()
    {
        return $this->hasOne('App\Subscription');
    }
    
    
}



