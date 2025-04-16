<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'lesson_tag', 'lesson_id', 'tag_id');
    }

    public function attached()
    {
        return $this->belongsTo(Upload::class, 'attached_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'lesson_student', 'lesson_id', 'student_id')
            ->withPivot('views')
            ->withTimestamps();
    }

    public function studentHasReachedMaxViews($studentId)
    {
        $countViews = $this->students->find($studentId)?->pivot?->views ?? 0;
        $maximumView = $this->view_count;
        if ($maximumView === 0) {
            return false;
        }
        return $countViews >= $maximumView;
    }
}
