<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
    use HasFactory;
    const CREATED_AT = null; //since we dont use create_at and updated_at column
    const UPDATED_AT = null;
    protected $fillable = ['survey_id','start_date','end_date'];
}
