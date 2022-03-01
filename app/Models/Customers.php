<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'location_area',
        'country_of_domicile',
        'gardener',
    ];

    public function gardener()
    {
        return $this->belongsTo(Gardeners::class, 'gardener', 'id');
    }

    public function country()
    {
        return $this->belongsTo(CountriesOfDomicile::class, 'country_of_domicile', 'id');
    }

    public function location()
    {
        return $this->belongsTo(LocationAreas::class, 'location_area', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(LocationAreas::class, 'location_area', 'id');
    }
}
