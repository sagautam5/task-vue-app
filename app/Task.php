<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'date', 'is_completed'];

    protected $hidden = ['created_at', 'updated_at'];

}
