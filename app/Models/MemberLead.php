<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MemberLead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'authnet_customer_profile_id',
        'authnet_customer_payment_profile_id',
    ];

    public function captureCustomerProfileId(string $profileId)
    {
        $this->update([
            'authnet_customer_profile_id' => $profileId,
        ]);
    }

    public function capturePaymentProfileId(string $paymentProfileId)
    {
        $this->update([
            'authnet_customer_payment_profile_id' => $paymentProfileId,
        ]);
    }

    public function convertToMember()
    {
        return $this->member()->create([
            'name' => $this->name,
            'email' => $this->email,
        ]);
    }

    public function member(): HasOne
    {
        return $this->hasOne(Member::class);
    }
}
