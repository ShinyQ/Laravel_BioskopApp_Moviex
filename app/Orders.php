<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Films;
use App\User;

class Orders extends Model
{
  use SoftDeletes;
  public $timestamps = true;
  protected $table = "orders";
  protected $fillable = ['user_id','film_id','qty','total_price'];

  function film(){
      return $this->hasOne(Films::class, "id", "film_id");
  }

  function user(){
      return $this->hasOne(User::class, "id", "user_id");
  }
}
