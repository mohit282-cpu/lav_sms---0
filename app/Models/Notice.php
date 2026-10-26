<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'notice_date',
        'notice_date_bs',
        'expiry_date',
        'expiry_date_bs',
        'created_by',
        'role_visibility',
        'my_class_id',
        'section_id',
        'is_published',
    ];

    protected $casts = [
        'notice_date' => 'date',
        'expiry_date' => 'date',
        'is_published' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function my_class()
    {
        return $this->belongsTo(MyClass::class, 'my_class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function scopeVisibleTo($query, $user)
    {
        if (!$user) {
            return $query->whereRaw('0 = 1');
        }

        if (in_array($user->user_type, ['super_admin', 'admin'])) {
            return $query;
        }

        $query->where('is_published', true);

        if ($user->user_type === 'teacher') {
            return $query->where(function ($q) {
                $q->whereIn('role_visibility', ['all', 'teacher'])
                  ->orWhereNull('role_visibility');
            });
        }

        if ($user->user_type === 'student') {
            $studentRecord = StudentRecord::where('user_id', $user->id)->first();
            $classId = $studentRecord ? $studentRecord->my_class_id : null;
            $sectionId = $studentRecord ? $studentRecord->section_id : null;

            return $query->where(function ($q) {
                $q->whereIn('role_visibility', ['all', 'student'])
                  ->orWhereNull('role_visibility');
            })->where(function ($q) use ($classId, $sectionId) {
                $q->whereNull('my_class_id');
                if ($classId) {
                    $q->orWhere(function ($sub) use ($classId, $sectionId) {
                        $sub->where('my_class_id', $classId)
                            ->where(function ($s) use ($sectionId) {
                                $s->whereNull('section_id')
                                  ->orWhere('section_id', $sectionId);
                            });
                    });
                }
            });
        }

        if ($user->user_type === 'parent') {
            $childrenClassIds = StudentRecord::where('my_parent_id', $user->id)->pluck('my_class_id')->filter()->unique()->toArray();

            return $query->where(function ($q) {
                $q->whereIn('role_visibility', ['all', 'parent'])
                  ->orWhereNull('role_visibility');
            })->where(function ($q) use ($childrenClassIds) {
                $q->whereNull('my_class_id');
                if (!empty($childrenClassIds)) {
                    $q->orWhereIn('my_class_id', $childrenClassIds);
                }
            });
        }

        return $query->where(function ($q) use ($user) {
            $q->whereIn('role_visibility', ['all', $user->user_type])
              ->orWhereNull('role_visibility');
        });
    }
}
