<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountriesOfDomicile extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'countries_of_domicile';

    public function locations()
    {
        return $this->hasMany(LocationAreas::class, 'country', 'id',);
    }

    public function customer()
    {
        return $this->hasOne(Customers::class, 'country_of_domicile', 'id',);
    }

    public function customers()
    {
        return $this->hasMany(Customers::class, 'country_of_domicile', 'id',);
    }

    public function gardeners()
    {
        return $this->hasMany(Gardeners::class, 'country_of_domicile', 'id',);
    }
}
