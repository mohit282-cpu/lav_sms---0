<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentLedgerEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'academic_year',
        'entry_type',
        'entry_date',
        'entry_date_bs',
        'reference_no',
        'debit',
        'credit',
        'running_balance',
        'source_type',
        'source_id',
        'description',
        'authorized_by',
    ];

    protected $casts = [
        'entry_date' => 'date',
        'debit' => 'float',
        'credit' => 'float',
        'running_balance' => 'float',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function authorizer()
    {
        return $this->belongsTo(User::class, 'authorized_by');
    }

    public function source()
    {
        return $this->morphTo(null, 'source_type', 'source_id');
    }
}
