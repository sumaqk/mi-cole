<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\TUser;

class TUserNotification extends Model
{
	protected $table='tusernotification';
	protected $primaryKey='idUserNotification';
	protected $keyType='string';
	public $incrementing=false;
	public $timestamps=true;

	public function tUser()
	{
		return $this->belongsTo(TUser::class, 'idUser');
	}
}
?>