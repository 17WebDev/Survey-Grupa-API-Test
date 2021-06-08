<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Survey;
use App\Models\User;

class Answer extends Model
{
    use HasFactory;

    public function getAnswerJsonAttribute($value)
    {
        return json_decode($value);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function survey(){
        return $this->belongsTo(Survey::class);
    }

}
