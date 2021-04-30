<?php

namespace App\Models;

use App\Models\Survey;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded=['id'];

    public function survey()
    {
        return $this->belongsTo(Survey::class,'survey_id','id');
    }
}
