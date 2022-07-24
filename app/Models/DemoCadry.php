<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class DemoCadry extends Model
{
    use HasFactory;

    protected $fillable = [
        'cadry_id',
        'railway_id',
        'organization_id',
        'department_id',
        'birth_region_id',
        'birth_city_id',
        'category_id',
        'pass_region_id',
        'pass_city_id',
        'address_region_id',
        'address_city_id',
        'education_id',
        'staff_id',
        'stavka',
        'photo',
        'phone',
        'nationality_id',
        'party_id',
        'academictitle_id',
        'academicdegree_id',
        'worklevel_id',
        'military_rank',
        'deputy',
        'language',
        'last_name',
        'first_name',
        'middle_name',
        'birht_date',
        'post_date',
        'post_name',
        'passport',
        'jshshir',
        'pass_date',
        'address',
        'sex',
        'job_date',
        'number',
        'comment',
        'status'
    ];
    
    public function organization()
    {
        return $this->belongsTo(Organization::class,'organization_id');
    }
    public function region()
    {
        return $this->belongsTo(Region::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    } 
    public function scopeFilter()
    {
        return self::query()
        ->when(request('org_id'), function ($query, $org_id) {
            return $query->where('organization_id', $org_id);

        })->when(request('dep_id'), function ($query, $dep_id) {
            return $query->where('department_id', $dep_id);

        })->when(request('railway_id'), function ($query, $railway_id) {
            return $query->where('railway_id', $railway_id);
        })->with(['organization','region','city']);
    }

    public function scopeDemoFilter()
    {
        return self::query()
        ->where('status', 0)
        ->when(\Request::input('jshshir'),function($query, $jshshir){
            $query->where(function ($query) use ($jshshir) {
                $query->Where('jshshir', 'LIKE', '%'. $jshshir .'%');
               
            });
        });
    }


    public function scopeOrgFilter()
    {
        return self::where('organization_id', UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'));
    }

}
