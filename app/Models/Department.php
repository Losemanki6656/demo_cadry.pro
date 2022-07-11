<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'railway_id',
        'organization_id',
        'name'
    ];
  
    public function cadries()
    {
        return $this->hasMany(Cadry::class);
    }
    
}
