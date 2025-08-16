<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tables extends Model
{
  protected $fillable = [''];
  protected $table = 'tables';

  public function tableClass()
  {
      return $this->belongsTo('App\Models\TableClasses', 'table_class_id');    
  }
}
