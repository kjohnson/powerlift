<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'member_id',
        'pin',
        'email',
        'authnet_subscription_id',
        'authnet_customer_profile_id',
        'authnet_customer_payment_profile_id__credit_card',
        'authnet_customer_payment_profile_id__bank_account',
        'waiver_signature',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'phone',
        'member_since',
        'notes',
        'contacts',
        'date_of_birth',
        'gender',
        'email2',
        'phone2',
    ];

    protected $casts = [
        'member_since' => 'date',
        'date_of_birth' => 'date',
    ];

    protected $hidden = [
        'pin',
    ];

    public function fullName()
    {
        return implode(' ', [
            $this->first_name,
            $this->last_name,
        ]);
    }

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
