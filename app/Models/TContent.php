<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TContent extends Model
{
    protected $table = 'tcontent';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'title', 'excerpt', 'content', 'featured_image', 'slug',
        'category', 'subcategory', 'tags', 'status', 'is_featured',
        'views_count', 'sort_order', 'published_at', 'created_by'
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
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

    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image) {
            return asset('storage/contenido/images/' . $this->featured_image);
        }
        return asset('images/default-content.jpg');
    }

    public function getUrlAttribute()
    {
        return route('home.content_detail', $this->id);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $readingTime = ceil($wordCount / 200);
        return $readingTime . ' min lectura';
    }

    public function getTagsArrayAttribute()
    {
        return $this->tags ? explode(',', $this->tags) : [];
    }
}