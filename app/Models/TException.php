<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\TUser;

class TException extends Model
{
	protected $table='texception';
	protected $primaryKey='idException';
	protected $keyType='string';
	public $incrementing=false;
	public $timestamps=true;

	public function tUser()
	{
		return $this->belongsTo(TUser::class, 'idUser');
	}
}
?>