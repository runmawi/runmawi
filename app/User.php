<?php

namespace App;

use App\UGCVideo;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;
use App\Permissions\HasPermissionsTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
    
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
    
    protected $fillable = [
                            'username', 'active', 'email', 'name', 'paypal_id', 'subscription_start','plan_name','preference_language',
                            'coupon_expired', 'payment_type', 'paypal_end_at', 'ccode', 'mobile','city','country','preference_genres',
                            'avatar','terms','stripe_active','sub_admin','referral_token', 'password', 'role', 'status', 'disabled', 'activation_code','provider',
                            'provider_id','g-recaptcha-response','subscription_ends_at','package','package_ends','provider_avatar','gender','DOB','Password_Pin','ios_avatar',
                            'otp','otp_request_id','otp_through','stripe_id','payment_status','payment_gateway','ugc_about','ugc_facebook','ugc_instagram','ugc_twitter','free_otp_status'
                        ];
   
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
    
  
    public function ugcVideos()
    {
        return $this->hasMany(UGCVideo::class);
    }
    
    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'ugc_subscribers', 'user_id', 'subscriber_id');
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
    public function phoneccode(){
		return $this->belongsTo('App\CountryCode','ccode','phonecode');
	}

    
}



