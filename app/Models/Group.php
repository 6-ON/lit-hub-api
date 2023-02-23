<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Group extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];
    protected $hidden = ['pivot'];

    public function sluggable(): array
    {
        return ['slug' => ['source' => 'title']];
    }

    public function owner()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function members()
    {
        return $this->belongsToMany(User::class, Membership::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
