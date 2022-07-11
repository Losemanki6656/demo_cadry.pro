<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendTask extends Model
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

   public function organization_send()
   {
        return $this->belongsTo(Organization::class,'org_send_id');
   }
   public function organization_rec()
   {
        return $this->belongsTo(Organization::class,'org_rec_id');
   }

   public function department_rec()
   {
        return $this->belongsTo(Department::class,'dep_rec_id');
   }

   public function department_send()
   {
        return $this->belongsTo(Department::class,'dep_send_id');
   }

   public function sendorganization()
   {
       return $this->belongsTo(UserOrganization::class,'send_id','user_id');
   }

      protected $dates = ['term'];
}
