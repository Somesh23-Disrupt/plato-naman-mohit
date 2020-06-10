<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $table= "meetings";



   public static function getRecordWithSlug($slug)
   {
       return Meeting::where('slug', '=', $slug)->first();
   }
}
