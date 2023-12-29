<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        $this->member()->associate(Member::create([
            'name' => $this->name,
            'email' => $this->email,
        ]));
        $this->save();
        return $this->member;
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
