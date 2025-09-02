<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
  protected $fillable = [
    'place_id',
    'place_token',
    'reservator_name',
    'validator_id',
        'total_amount',
        'payment_status',
        'payment_method',
        'status',
  ];
  protected $table = 'orders';
  
  public function place()
  {
      return $this->belongsTo('App\Models\Places', 'place_id');    
  }

  public function placeCategory()
  {
      return $this->belongsTo('App\Models\PlaceCategories', 'place_category_id');    
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
