<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Films extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    protected $table = "films";
    protected $fillable = ['name','deskripsi','genre_id','start_at','end_at','studio_id'];
}
