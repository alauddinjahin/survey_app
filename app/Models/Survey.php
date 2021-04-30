<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $guarded=['id'];

    public function questions()
    {
        return $this->hasMany(Question::class,'survey_id','id');
    }
}
