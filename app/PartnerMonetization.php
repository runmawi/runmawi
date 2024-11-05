<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartnerMonetization extends Model
{
    protected $guarded = array();

    protected $table = 'partner_monetizations';

    public static $rules = array();

    public function channeluser()
    {
        return $this->belongsTo('App\Channel', 'user_id', 'id');
    }

    public function video()
    {
        return $this->belongsTo('App\Video', 'type_id', 'id');
    }

    public function episode()
    {
        return $this->belongsTo('App\Episode', 'type_id', 'id');
    }

    public function livestream()
    {
        return $this->belongsTo('App\LiveStream', 'type_id', 'id');
    }

    public function content()
    {
        switch ($this->type) {
            case 'video':
                return $this->video();
                break;
            case 'episode':
                return $this->episode();
                break;

            case 'livestream':
                return $this->livestream();
                break;

            default:
                return null;
                break;
        }

        return null;
    }

}
