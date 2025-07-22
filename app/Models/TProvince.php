<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\TDistrict;

class TProvince extends Model
{
	protected $table='tprovince';
	protected $primaryKey='idProvince';
	protected $keyType='string';
	public $incrementing=false;
	public $timestamps=true;

	public function tDistrict()
	{
		return $this->hasMany(TDistrict::class, 'idProvince');
	}
}
?>