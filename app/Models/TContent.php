<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TContent extends Model
{
	protected $table='tcontent';
	protected $primaryKey='id';
	protected $keyType='int';
	public $incrementing=false;
	public $timestamps=true;

}
?>