<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'fee_category_id',
        'academic_year',
        'my_class_id',
        'section_id',
        'student_id',
        'amount',
        'period_type',
        'due_day',
        'is_taxable',
        'tax_rate',
        'description',
        'is_active',
    ];

    protected $casts = [
        'amount' => 'float',
        'is_taxable' => 'boolean',
        'tax_rate' => 'float',
        'due_day' => 'integer',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(FeeCategory::class, 'fee_category_id');
    }

    public function my_class()
    {
        return $this->belongsTo(MyClass::class, 'my_class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
