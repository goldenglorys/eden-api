<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gardeners extends Model
{
  use HasFactory;

  protected $fillable = [
    'full_name',
    'email',
    'location_area',
    'country_of_domicile',
  ];

  public function customer()
  {
    return $this->hasOne(Customers::class, 'gardener', 'id',);
  }

  public function location()
  {
    return $this->belongsTo(LocationAreas::class, 'location_area', 'id');
  }

  public function country()
  {
    return $this->belongsTo(CountriesOfDomicile::class, 'country_of_domicile', 'id');
  }
}
