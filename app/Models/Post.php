<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];
    protected $appends = ['user_reaction'];
    protected $with = ['owner:id,username,image', 'category:id,label,slug'];
    protected $withCount = ['reactions', 'comments'];
    public function scopeFilter($filters)
    {
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function sluggable(): array
    {
        return ['slug' => ['source' => 'title']];
    }

    protected function userReaction(): Attribute
    {
        return new Attribute(
            get: function () {
                if (request()->user() ?? false) {
                    return $this->reactions()->where('user_id', request()->user()->id)->first();
                }
                return null;
            }
        );
    }
}
