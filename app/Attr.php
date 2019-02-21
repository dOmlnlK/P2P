<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attr extends Model
{
    //
    public $timestamps = false;
    protected $primaryKey = 'aid';

    protected $fillable = ['age','pid','uid'];
}
