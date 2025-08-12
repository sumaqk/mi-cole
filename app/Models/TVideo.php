<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TVideo extends Model
{
    protected $table = 'tvideo';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'title', 'description', 'video_path', 'thumbnail', 'youtube_url',
        'category', 'status', 'sort_order', 'created_by'
    ];

    protected $casts = [
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function creator()
    {
        return $this->belongsTo(TUser::class, 'created_by', 'idUser');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('material_agua/videos/thumbnails/' . $this->thumbnail);
        }
        return asset('images/default-video.jpg');
    }

    public function getVideoUrlAttribute()
    {
        if ($this->youtube_url) {
            return $this->youtube_url;
        }
        if ($this->video_path) {
            return asset($this->video_path);
        }
        return null;
    }

    public function getIsYoutubeAttribute()
    {
        return !empty($this->youtube_url);
    }

    public function getYoutubeEmbedAttribute()
    {
        if ($this->youtube_url) {
            preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/', $this->youtube_url, $matches);
            $videoId = $matches[1] ?? '';
            return "https://www.youtube.com/embed/{$videoId}";
        }
        return null;
    }
}