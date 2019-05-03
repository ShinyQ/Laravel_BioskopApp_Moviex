<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
  use SoftDeletes;
  public $timestamps = true;
  protected $table = "orders";
  protected $fillable = ['user_id','film_id','qty','total_price'];
}
