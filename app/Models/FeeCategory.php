<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'fee_type',
        'is_taxable',
        'tax_rate',
        'is_active',
    ];

    protected $casts = [
        'is_taxable' => 'boolean',
        'tax_rate' => 'float',
        'is_active' => 'boolean',
    ];

    public function fee_structures()
    {
        return $this->hasMany(FeeStructure::class);
    }

    public function invoice_items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
