<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\TUser;
use App\Models\TInstitution;

class TInstitutionTUser extends Model
{
	protected $table='tinstitutiontuser';
	protected $primaryKey='idInstitutionTUser';
	protected $keyType='string';
	public $incrementing=false;
	public $timestamps=true;

    public function tInstitution()
	{
		return $this->belongsTo(TInstitution::class, 'idInstitution');
	}

	public function tUser()
	{
		return $this->belongsTo(TUser::class, 'idUser');
	}
}
?>