<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TVideo extends Model
{
	protected $table='tvideo';
	protected $primaryKey='id';
	protected $keyType='int';
	public $incrementing=false;
	public $timestamps=true;

}
?>