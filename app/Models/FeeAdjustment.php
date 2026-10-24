<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeAdjustment extends Model
{
    use HasFactory;

    protected $fillable = [
        'adjustment_no',
        'student_id',
        'invoice_id',
        'fee_payment_id',
        'adjustment_type',
        'amount',
        'reason',
        'authorized_by',
        'academic_year',
        'adjustment_date',
        'adjustment_date_bs',
        'idempotency_token',
    ];

    protected $casts = [
        'amount' => 'float',
        'adjustment_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function payment()
    {
        return $this->belongsTo(FeePayment::class, 'fee_payment_id');
    }

    public function authorizer()
    {
        return $this->belongsTo(User::class, 'authorized_by');
    }
}
