<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artigo extends Model
{

    protected $fillable = ['titulo','texto','created_at','updated_at'];
    
}
