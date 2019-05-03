<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Studios extends Model
{
  use SoftDeletes;
  public $timestamps = true;
  protected $table = "studios";
  protected $fillable = ['name','quota','price'];
}
