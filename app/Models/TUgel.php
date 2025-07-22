<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TUgel extends Model
{
    protected $table = 'tugel';
    protected $primaryKey = 'idUgel';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'idUgel',
        'name',
        'code',
        'idProvince',
        'idDistrict',
        'address',
        'phone',
        'email',
        'director',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function tProvince()
    {
        return $this->belongsTo(TProvince::class, 'idProvince', 'idProvince');
    }

    public function tDistrict()
    {
        return $this->belongsTo(TDistrict::class, 'idDistrict', 'idDistrict');
    }

    public function tInstitution()
    {
        return $this->hasMany(TInstitution::class, 'idUgel');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getStatusTextAttribute()
    {
        return $this->is_active ? 'Activa' : 'Inactiva';
    }

    public function getFullLocationAttribute()
    {
        return $this->tProvince->name . ' - ' . $this->tDistrict->name;
    }
}