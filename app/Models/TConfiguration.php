<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TConfiguration extends Model
{
	protected $table='tconfiguration';
	protected $primaryKey='idConfiguration';
	protected $keyType='string';
	public $incrementing=false;
	public $timestamps=true;
}
?>