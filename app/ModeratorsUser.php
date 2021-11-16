<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ModeratorsUser extends Model
{
    // use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

                
    protected $guarded = ['id'];

    protected $fillable = [
        // 'id',
        'username',
        'email_id',
        'mobile_number',
        'password',
        'confirm_password',
        'description',
        'picture',
        'user_role',
        'user_permission',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	protected $table = 'moderators_users';

    public function getAuthPassword()
    {
     return $this->password;
    }

    public function total_videos(){
        return $this->belongsTo('App\Video','id','user_id');
    }
}
