<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Permissions\HasPermissionsTrait;
use Laravel\Cashier\Billable;
use Illuminate\Support\Facades\Hash;  // Import Hash facade

class User extends Authenticatable
{
    use Notifiable;
    
    use HasPermissionsTrait; //Import The Trait
    
    use Billable;

    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [ 'username', 'active', 'email', 'terms', 'name', 'mobile', 'referrer_id','avatar','terms','stripe_active','sub_admin', 'password', 'role', 'status', 'disabled', 'activation_code'];
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
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
    
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
    

}
