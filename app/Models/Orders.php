<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
  protected $fillable = [''];
  protected $table = 'orders';
  
  public function table()
  {
      return $this->belongsTo('App\Models\Tables', 'table_id');    
  }

  public function validator()
  {
      return $this->belongsTo('App\Models\Users', 'validator_id');    
  }

  public function detail()
  {
      return $this->hasMany('App\Models\OrderDetails', 'order_id');    
  }
}
