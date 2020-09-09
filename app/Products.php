<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //
    protected $guarded = [];

    public function users(){
        return $this->hasMany(User::class);
    }

}
