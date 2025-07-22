<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\TInstitution;

class TWater extends Model
{
	protected $table='twater';
	protected $primaryKey='idWater';
	protected $keyType='string';
	public $incrementing=false;
	public $timestamps=true;

    public function tInstitution()
	{
		return $this->belongsTo(TInstitution::class, 'idInstitution');
	}
}
?>