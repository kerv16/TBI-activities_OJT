<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'image',
        'body',
        'attachments',
        'published_at',
        'featured',
        'number_of_participants',
        'event_type',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'attachments' => 'array',
    ];

    protected static function booted()
    {
        static::deleting(function ($post) {
            // Delete the thumbnail
            Storage::disk('public')->delete($post->image);

            // Parse the body content and delete the attachment
            $bodyContent = json_decode($post->body, true);
            if (isset($bodyContent['data-trix-attachment'])) {
                $attachment = json_decode($bodyContent['data-trix-attachment'], true);
                if (isset($attachment['href'])) {
                    $filePath = str_replace('http://127.0.0.1:8000/storage/', '', $attachment['href']);
                    $filePath = 'posts/images/' . $filePath; // prepend the directory path
                    Storage::disk('public')->delete($filePath);
                }
            }
        });
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function scopePublished($query)
    {
        $query->where('published_at', '<=', Carbon::now());
    }

    public function scopeWithCategory($query, string $category)
    {
        $query->whereHas('categories', function ($query) use ($category) {
            $query->where('slug', $category);
        });
    }

    public function getExcerpt()
    {
        return Str::limit(strip_tags($this->body), 150);
    }

    public function getReadingTime()
    {
        $mins = round(str_word_count($this->body) / 250);

        return ($mins < 1) ? 1 : $mins;
    }

    public function getThumbnailUrl()
    {
        $isUrl = str_contains($this->image, 'http');
    
        return $isUrl ? $this->image : '/storage/' . $this->image;
    }
    public function getAttachmentUrls()
    {
        $urls = [];
        foreach ($this->attachments as $attachment) {
            $isUrl = str_contains($attachment, 'http');
            $urls[] = $isUrl ? $attachment : Storage::disk('public')->url($attachment);
        }
        return $urls;
    }
}
