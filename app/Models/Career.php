<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class Career extends Model
{
    use HasFactory, RevisionableTrait;

    protected $fillable = [
        'cadry_id',
        'sort',
        'date1',
        'date2',
        'staff',
    ];

    protected $dates = ['date1','date2'];
}
