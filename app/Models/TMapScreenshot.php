<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TMapScreenshot extends Model
{
    protected $table = 'tmap_screenshots';
    
    protected $fillable = [
        'filename',
        'filepath',
        'capture_date',
        'year',
        'month',
        'month_name',
        'is_automatic',
        'description',
        'metadata'
    ];
    
    protected $casts = [
        'capture_date' => 'date',
        'is_automatic' => 'boolean',
        'metadata' => 'array'
    ];
    
    /**
     * Obtener el último día del mes actual
     */
    public static function getLastDayOfMonth($year = null, $month = null)
    {
        $year = $year ?? date('Y');
        $month = $month ?? date('n');
        return Carbon::create($year, $month)->lastOfMonth();
    }
    
    /**
     * Verificar si es el último día del mes
     */
    public static function isLastDayOfMonth()
    {
        $today = Carbon::now();
        $lastDay = static::getLastDayOfMonth();
        return $today->isSameDay($lastDay);
    }
    
    /**
     * Obtener nombre del mes en español
     */
    public static function getSpanishMonthName($month)
    {
        $months = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];
        return $months[$month] ?? 'Desconocido';
    }
    
    /**
     * Scope para capturas automáticas
     */
    public function scopeAutomatic($query)
    {
        return $query->where('is_automatic', true);
    }
    
    /**
     * Scope para capturas manuales
     */
    public function scopeManual($query)
    {
        return $query->where('is_automatic', false);
    }
    
    /**
     * Scope para un año específico
     */
    public function scopeYear($query, $year)
    {
        return $query->where('year', $year);
    }
    
    /**
     * Scope para un mes específico
     */
    public function scopeMonth($query, $month)
    {
        return $query->where('month', $month);
    }
}