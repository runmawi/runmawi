<?php

namespace App;

use App\UGCVideo;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;
use App\Permissions\HasPermissionsTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Notifications\ResetPasswordNotification;
use Carbon\Carbon;
use App\Subscriber;
class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasPermissionsTrait, Billable;

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
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    protected $dates = ['trial_ends_at', 'subscription_ends_at'];

    public static $rules = [
        'username' => 'required|unique:users|min:3',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed|min:3'
    ];

    public static $update_rules = [
        'username' => 'unique:users|min:3',
        'email' => 'email|unique:users'
    ];

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
        return $this->hasMany(CouponPurchase::class, 'ref_id', 'id');
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
        return $this->hasOne(Subscription::class);
    }

    public function phoneccode()
    {
        return $this->belongsTo(CountryCode::class,'ccode','phonecode');
    }

    /**
     * ✅ New: Override role accessor to return "subscriber" dynamically
     */
    public function getRoleAttribute($value)
    {   
        $subscriber = \DB::table('subscriber')
            ->where('user_id', $this->id)
            ->where('end_date', '>=', now())
            ->first();

        if ($subscriber) {
            return 'subscriber';
        }

        return $value;
    }
}
