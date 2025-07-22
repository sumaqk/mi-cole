<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\TProvince;
use App\Models\TInstitution;

class TDistrict extends Model
{
	protected $table='tdistrict';
	protected $primaryKey='idDistrict';
	protected $keyType='string';
	public $incrementing=false;
	public $timestamps=true;

    public function tProvince()
	{
		return $this->belongsTo(TProvince::class, 'idProvince');
	}

    public function tInstitution()
	{
		return $this->hasMany(TInstitution::class, 'idDistrict');
	}
}
?>