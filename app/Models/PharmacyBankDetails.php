<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyBankDetails extends Model
{
    use HasFactory;

    protected $table = 'pharmacy_bank_details';

    protected $fillable = [
        'pmId',
        'bankname',
        'branchname',
        'account_type',
        'account_name',
        'account_number',
        'ifsccode',
        'status',
    ];

    public function pharmacyMaster()
    {
        return $this->belongsTo(PharmacyMaster::class, 'pmId', 'PharmacyID');
    }
}
