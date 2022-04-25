<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Googlemeet extends Model
{
    use HasFactory;

    protected $table = 'googlemeets';

    protected $fillable = ['meeting_id', 'owner_id', 'start_time', 'meet_url', 'user_id', 'meeting_title', 'course_id', 'link_by', 'type', 'agenda', 'image'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function courses()
    {
    	return $this->belongsTo('App\Course','course_id','id');
    }
}
