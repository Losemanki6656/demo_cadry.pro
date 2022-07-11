<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOrganization extends Model
{
    use HasFactory;

    public function organization()
    {
        return $this->belongsTo(Organization::class,'organization_id');
    }

    public function railway()
    {
        return $this->belongsTo(Railway::class);
    }
}
