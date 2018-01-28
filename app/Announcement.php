<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class Announcement extends Model 
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'announcements';

    public function order()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
