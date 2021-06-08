<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Option;
use App\Models\Survey;

class Question extends Model
{
    use HasFactory;

    public function options(){
        return $this->hasMany(Option::class);
    }

    public function survey(){
        return $this->belongsTo(Survey::class);
    }
}
