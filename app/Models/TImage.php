<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\TWater;

class TImage extends Model
{
	protected $table='timage';
	protected $primaryKey='idImage';
	protected $keyType='string';
	public $incrementing=false;
	public $timestamps=true;

    public function tWater()
	{
		return $this->belongsTo(TWater::class, 'idWater');
	}
}
?>