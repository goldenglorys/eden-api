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
}
