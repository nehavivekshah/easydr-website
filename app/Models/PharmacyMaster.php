<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyMaster extends Model
{
    use HasFactory;

    protected $primaryKey = 'PharmacyID';
    public $timestamps = false;

    protected $casts = [
        'HoursOfOperation' => 'array',
        'TaxID' => 'array',
    ];

    protected $fillable = [
        'PharmacyName',
        'PharmacyCode',
        'Address',
        'City',
        'State',
        'ZipCode',
        'MobileNumber',
        'PhoneNumber',
        'FaxNumber',
        'EmailAddress',
        'WebsiteURL',
        'NPI',
        'DEANumber',
        'LicenseNumber',
        'LicenseExpirationDate',
        'PharmacyType',
        'OwnershipType',
        'HoursOfOperation',
        'EmergencyServices',
        'ServicesOffered',
        'PrimaryContactName',
        'Designation',
        'TaxID',
    ];

    public function pharmacyBankDetails()
    {
        return $this->hasOne(PharmacyBankDetails::class, 'pmId', 'PharmacyID');
    }
}
