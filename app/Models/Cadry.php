<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUploadFields;
use \Venturecraft\Revisionable\RevisionableTrait;
use Auth;

class Cadry extends Model
{
    use HasFactory;
    use HasUploadFields;
    //use RevisionableTrait;
   
    protected $guarded = ['id'];
    
    protected $casts = [
        'stavka' => 'double'
    ];
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $model) {
            if (!isset($model->photo)) {
                $model->attributes['photo'] = '/app-assets/images/favicon.png';
            }
        });
    }

    public function med()
    {
        return $this->hasOne(MedicalExamination::class)->where(['status' => true]);
    }

    public function vacation()
    {
        return $this->hasMany(Vacation::class);
    }
    public function cadry_degree()
    {
        return $this->belongsTo(AcademicDegree::class,'academicdegree_id');
    }
    public function cadry_title()
    {
        return $this->belongsTo(AcademicTitle::class,'academictitle_id');
    }
    public function nationality()
    {
        return $this->belongsTo(Nationality::class,'nationality_id');
    }
    public function info_education()
    {
        return $this->belongsTo(InfoEducation::class,'id','cadry_id');
    }
    public function party()
    {
        return $this->belongsTo(Party::class,'party_id');
    }
    public function address_region()
    {
        return $this->belongsTo(Region::class,'address_region_id');
    }
    public function address_city()
    {
        return $this->belongsTo(City::class,'address_city_id');
    }
    public function birth_region()
    {
        return $this->belongsTo(Region::class,'birth_region_id');
    }
    public function birth_city()
    {
        return $this->belongsTo(City::class,'birth_city_id');
    }
    public function pass_city()
    {
        return $this->belongsTo(City::class,'pass_city_id');
    }
    public function pass_region()
    {
        return $this->belongsTo(Region::class,'pass_region_id');
    }
    public function education()
    {
        return $this->belongsTo(Education::class,'education_id');
    }
    public function instituts()
    {
        return $this->hasMany(InfoEducation::class);
    }
    public function incentives()
    {
        return $this->hasMany(Incentive::class);
    }
    public function relatives()
    {
        return $this->hasMany(CadryRelative::class);
    }
    public function allStaffs()
    {
        return $this->hasMany(DepartmentCadry::class);
    }
    public function careers()
    {
        return $this->hasMany(Career::class);
    }
    public function discips()
    {
        return $this->hasMany(DisciplinaryAction::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class,'department_id');
    }
    public function staff()
    {
        return $this->belongsTo(Staff::class,'staff_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class,'organization_id');
    }
       
    public function setLanguageAttribute($value)
    {   
        if(is_array($value) == true) 
            $this->attributes['language'] = implode($value, ',');
        else $this->attributes['language'] = $value;
    }

    public function setAddressAttribute($value)
    {
        if($value == null) $this->attributes['address'] = " ";
        else
        $this->attributes['address'] = $value;
    }

    public function setPhotoAttribute($value)
    {
        if($value == null)  $this->setPhotoAttribute = ''; 
            else 
            {
                $attribute_name = "photo";
                $disk = "public";
                $destination_path = 'cadry-photos'; 
                $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
            }
    }    
    
    public function scopeFilter()
    {
        return self::query()
        ->where('status',true)
        ->when(\Request::input('name_se'),function($query,$name_se){
            $query->where(function ($query) use ($name_se) {
                foreach(explode(' ',$name_se) as $item)
                $query->orWhere('last_name', 'LIKE', '%'. $item .'%')
                    ->orWhere('first_name', 'LIKE', '%'.$item.'%')
                    ->orWhere('middle_name', 'LIKE', '%'.$item.'%');
               
            });
        })->when(request('railway_id'), function ( $query, $railway_id) {
                return $query->where('railway_id', $railway_id);
                
        })->when(request('org_id'), function ( $query, $org_id) {
                return $query->where('organization_id', $org_id);

        })->when(request('dep_id'), function ( $query, $dep_id) {
                return $query->where('department_id', $dep_id);

        })->when(request('staff_se'), function ($query, $staff_se) {
            return $query->where('staff_id', $staff_se);

        })->when(request('education_se'), function ($query, $education_se) {
            return $query->where('education_id', $education_se);

        })->when(request('region_se'), function ($query, $region_se) {
            return $query->where('birth_region_id', $region_se);

        })->when(request('sex_se'), function ($query, $sex_se) {
            if($sex_se == "true") $z = true; else $z = false;
            return $query->where('sex', $z);

        })->when(request('start_se'), function ($query, $start_se) {
            return $query->whereYear('birht_date', '<=', now()->format('Y') - $start_se);

        })->when(request('end_se'), function ($query, $end_se) {
            return $query->whereYear('birht_date', '>=', now()->format('Y') - $end_se);

        });
    }

    public function scopeFullFilter()
    {
        return self::query()
        ->where('status',true)
        ->where('organization_id', auth()->user()->userorganization->organization_id)
        ->when(\Request::input('name_se'),function($query,$name_se){
            $query->where(function ($query) use ($name_se) {
                foreach(explode(' ',$name_se) as $item)
                $query->orWhere('last_name', 'LIKE', '%'. $item .'%')
                    ->orWhere('first_name', 'LIKE', '%'.$item.'%')
                    ->orWhere('middle_name', 'LIKE', '%'.$item.'%');
               
            });
        })->when(request('staff_se'), function ($query, $staff_se) {
            return $query->where('staff_id', $staff_se);

        })->when(request('education_se'), function ($query, $education_se) {
            return $query->where('education_id', $education_se);

        })->when(request('region_se'), function ($query, $region_se) {
            return $query->where('birth_region_id', $region_se);

        })->when(request('department_se'), function ($query, $department_se) {
            return $query->where('department_id', $department_se);

        })->when(request('sex_se'), function ($query, $sex_se) {
            if($sex_se == "true") $z = true; else $z = false;
            return $query->where('sex', $z);

        })->when(request('start_se'), function ($query, $start_se) {
            return $query->whereYear('birht_date', '<=', now()->format('Y') - $start_se);

        })->when(request('end_se'), function ($query, $end_se) {
            return $query->whereYear('birht_date', '>=', now()->format('Y') - $end_se);

        });
    }

    public function scopeOrgFilter()
    {
        return self::where('organization_id', auth()->user()->userorganization->organization_id)->where('status',true);
    }

    public function scopeDemoFilter()
    {
        return self::query()
        ->where('status', false)
        ->when(\Request::input('jshshir'),function($query, $jshshir){
            $query->where(function ($query) use ($jshshir) {
                $query->Where('jshshir', 'LIKE', '%'. $jshshir .'%');
            });
        });
    }

    public function scopeSeFilter()
    {
        return self::query()
        ->where('organization_id',auth()->user()->userorganization->organization_id)
        ->when(\Request::input('name_se'),function($query,$name_se){
           $query->where(function ($query) use ($name_se) {
              $query->orWhere('last_name', 'LIKE', '%'. $name_se .'%')
                    ->orWhere('first_name', 'LIKE', '%'.$name_se.'%')
                    ->orWhere('middle_name', 'LIKE', '%'.$name_se.'%');
              
           });
        });
    }

}
