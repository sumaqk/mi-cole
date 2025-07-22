<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TDistrict;
use App\Models\TWater;
use App\Models\TInstitutionTUser;
use App\Models\TUgel;

class TInstitution extends Model 
{
    protected $table='tinstitution';
    protected $primaryKey='idInstitution';
    protected $keyType='string';
    public $incrementing=false;
    public $timestamps=true;


    protected $fillable = [
        'idInstitution',
        'name',
        'lender',
        'idDistrict',
        'idUgel'
    ];

    public function tDistrict()
    {
        return $this->belongsTo(TDistrict::class, 'idDistrict', 'idDistrict'); // Especificar claves
    }

    public function tInstitutionTUser()
    {
        return $this->hasMany(TInstitutionTUser::class, 'idInstitution');
    }

    public function tWater()
    {
        return $this->hasMany(TWater::class, 'idInstitution');
    }

    public function tUgel()
    {
        return $this->belongsTo(TUgel::class, 'idUgel', 'idUgel'); // Especificar claves
    }
}
?>