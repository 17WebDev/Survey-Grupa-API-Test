<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use App\Models\Option;
class Survey extends Model
{
    use HasFactory;

    public function getSurveyJsonAttribute($value)
    {
        return json_decode($value);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function options(){
        return $this->hasManyThrough(Option::class, Question::class);
    }
}
