<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
  protected $fillable = [
    'table_id',
    'table_token',
    'reservator_name',
        'total_amount',
        'payment_status',
        'payment_method',
        'status',
  ];
  protected $table = 'orders';
  
  public function table()
  {
      return $this->belongsTo('App\Models\Tables', 'table_id');    
  }

  public function validator()
  {
      return $this->belongsTo('App\Models\Users', 'validator_id');    
  }

  public function details()
  {
      return $this->hasMany('App\Models\OrderDetails', 'order_id');    
  }
}
