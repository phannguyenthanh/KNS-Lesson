<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonContent extends Model
{
    public function lessonDetail()
    {
        return $this->belongsTo(LessonDetail::class);
    }
}