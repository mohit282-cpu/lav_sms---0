<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'student_id',
        'my_class_id',
        'section_id',
        'academic_year',
        'fee_period',
        'invoice_date',
        'invoice_date_bs',
        'due_date',
        'due_date_bs',
        'subtotal',
        'discount_amount',
        'taxable_amount',
        'tax_amount',
        'net_total',
        'paid_amount',
        'balance',
        'status',
        'notes',
        'created_by',
        'idempotency_token',
        'legacy_pr_id',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'float',
        'discount_amount' => 'float',
        'taxable_amount' => 'float',
        'tax_amount' => 'float',
        'net_total' => 'float',
        'paid_amount' => 'float',
        'balance' => 'float',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function my_class()
    {
        return $this->belongsTo(MyClass::class, 'my_class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments()
    {
        return $this->hasMany(FeePayment::class);
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
