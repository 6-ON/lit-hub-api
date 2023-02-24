<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['user:id,username,image'];

    protected $hidden =[
      'post_id','user_id','created_at','updated_at'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
