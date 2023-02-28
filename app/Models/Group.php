<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Group extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];
    protected $hidden = ['pivot'];

    protected $appends = ['is_joined'];

    public function sluggable(): array
    {
        return ['slug' => ['source' => 'title']];
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function members()
    {
        return $this->belongsToMany(User::class, Membership::class);
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    protected function isJoined(): Attribute
    {
        return new Attribute(
            get: function () {
                if (request()->user() ?? false) {
                    return $this->memberships()->where('user_id',request()->user()->id)->exists();
                }
                return false;
            }
        );
    }
}
