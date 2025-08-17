<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
  protected $fillable = [
    'order_id',
  'menu_id',
  'quantity',
  'price',
  'subtotal',
  'note',
];
  protected $table = 'order_details';
  
  public function order()
  {
      return $this->belongsTo('App\Models\Orders', 'order_id');    
  }

  public function menu()
  {
      return $this->belongsTo('App\Models\Menus', 'menu_id');    
  }
}
