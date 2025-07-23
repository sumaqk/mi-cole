<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\TException;
use App\Models\TInstitutionTUser;

class TUser extends Model
{
	protected $table='tuser';
	protected $primaryKey='idUser';
	protected $keyType='string';
	public $incrementing=false;
	public $timestamps=true;

	public function tException()
	{
		return $this->hasMany(TException::class, 'idUser');
	}

	public function tInstitutionTUser()
	{
		return $this->hasMany(TInstitutionTUser::class, 'idUser');
	}

	public function tProvince()
	{
		return $this->belongsTo(TProvince::class, 'idProvince');
	}

	public function tDistrict()
	{
		return $this->belongsTo(TDistrict::class, 'idDistrict');
	}

}
?>