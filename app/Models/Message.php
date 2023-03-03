<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $with = ['user:id,username,image'];
    protected $guarded = ['id'];
    protected $appends = ['from_user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected function fromUser(): Attribute
    {
        return new Attribute(
            get: function () {
                if (request()->user() ?? false) {
                    return $this->user()->is(request()->user());
                }
                return false;
            }
        );
    }
}
