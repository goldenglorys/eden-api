<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationAreas extends Model
{
    use HasFactory;

    public function country()
    {
        return $this->belongsTo(CountriesOfDomicile::class, 'country', 'id');
    }

    public function customer()
    {
        return $this->hasOne(Customers::class, 'location_area', 'id',);
    }

    public function customers()
    {
        return $this->hasMany(Customers::class, 'location_area', 'id',);
    }
}
