<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Genres;
use App\Studios;

class Films extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    protected $table = "films";
    protected $fillable = ['name','deskripsi','genre_id','start_at','end_at','studio_id'];

    function genre(){
        return $this->hasOne(Genres::class, "id", "genre_id");
    }

    function studio(){
        return $this->hasOne(Studios::class, "id", "studio_id");
    }
}
