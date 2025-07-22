<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModalSetting extends Model
{
    protected $fillable = ['content', 'is_active', 'start_date', 'end_date'];

    public function isModalActive()
    {
        $now = now();
        return $this->is_active && $this->start_date <= $now && $this->end_date >= $now;
    }
}
