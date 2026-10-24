<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'fee_category_id',
        'fee_structure_id',
        'title',
        'description',
        'unit_price',
        'quantity',
        'gross_amount',
        'discount_amount',
        'taxable_amount',
        'tax_rate',
        'tax_amount',
        'net_amount',
    ];

    protected $casts = [
        'unit_price' => 'float',
        'quantity' => 'float',
        'gross_amount' => 'float',
        'discount_amount' => 'float',
        'taxable_amount' => 'float',
        'tax_rate' => 'float',
        'tax_amount' => 'float',
        'net_amount' => 'float',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function category()
    {
        return $this->belongsTo(FeeCategory::class, 'fee_category_id');
    }

    public function structure()
    {
        return $this->belongsTo(FeeStructure::class, 'fee_structure_id');
    }
}
