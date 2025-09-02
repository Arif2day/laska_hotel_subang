<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Places extends Model
{
  protected $fillable = [''];
  protected $table = 'places';

  public function placeCategory()
  {
      return $this->belongsTo('App\Models\PlaceCategories', 'place_category_id');    
  }
}
