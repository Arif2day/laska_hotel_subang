<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
  protected $fillable = [''];
  protected $table = 'menus';
  
  public function menuType()
  {
      return $this->belongsTo('App\Models\MenuTypes', 'menu_type_id');    
  }

  public function orderDetails()
  {
      return $this->hasMany('App\Models\OrderDetails');
  }
}
