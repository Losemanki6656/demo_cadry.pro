<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendFile extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class,'recipient_id');
    }

    public function userrec()
    {
        return $this->belongsTo(User::class,'send_id');
    }

    
   public function recorganization()
   {
       return $this->belongsTo(UserOrganization::class,'recipient_id','user_id');
   }

    public function sendorganization()
    {
        return $this->belongsTo(UserOrganization::class,'send_id','user_id');
    }

    protected $dates = ['term'];
}
