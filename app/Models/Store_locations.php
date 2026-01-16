<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store_locations extends Model
{
    use HasFactory;

    protected $casts = [
        'HoursOfOperation' => 'array'
    ];
    
    protected $fillable = [
        'PharmacyID', 'LocationName', 'Address', 'City', 'State', 'ZipCode',  'MapLink', 'PhoneNumber', 'HoursOfOperation', 'ContactName', 'Designation', 'ContactEmail', 'Latitude', 'Longitude', 'ManagerName', 'SquareFootage', 'AccessibilityFeatures'
    ];
    													
    protected $primaryKey = 'LocationID';
    public $timestamps = false;

}
