<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_no',
        'invoice_id',
        'student_id',
        'amount',
        'payment_method',
        'transaction_reference',
        'payment_date',
        'payment_date_bs',
        'academic_year',
        'received_by',
        'notes',
        'status',
        'idempotency_token',
        'legacy_pr_id',
    ];

    protected $casts = [
        'amount' => 'float',
        'payment_date' => 'date',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function allocations()
    {
        return $this->hasMany(FeePaymentAllocation::class);
    }

    public function adjustments()
    {
        return $this->hasMany(FeeAdjustment::class);
    }
}
