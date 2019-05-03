<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Genres extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    protected $table = "genres";
    protected $fillable = ['name'];
}
