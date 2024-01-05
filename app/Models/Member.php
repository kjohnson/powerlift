<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'member_id',
        'email',
        'authnet_subscription_id',
        'authnet_customer_profile_id',
        'authnet_customer_payment_profile_id__credit_card',
        'authnet_customer_payment_profile_id__bank_account',
    ];

    protected $hidden = [
        'pin',
    ];

    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }

    public function captureCustomerProfileId(string $profileId)
    {
        $this->update([
            'authnet_customer_profile_id' => $profileId,
        ]);
    }

    public function capturePaymentProfileIdCreditCard(string $paymentProfileId)
    {
        $this->update([
            'authnet_customer_payment_profile_id__credit_card' => $paymentProfileId,
        ]);
    }

    public function capturePaymentProfileIdBankAccount(string $paymentProfileId)
    {
        $this->update([
            'authnet_customer_payment_profile_id__bank_account' => $paymentProfileId,
        ]);
    }
}
