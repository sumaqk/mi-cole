<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TGallery extends Model
{
	protected $table='gallery';
	protected $primaryKey='id';
	protected $keyType='int';
	public $incrementing=false;
	public $timestamps=true;

}
?>