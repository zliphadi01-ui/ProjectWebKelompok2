<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Icd9Procedure extends Model
{
    protected $table = 'icd9_procedures';
    protected $guarded = ['id'];
}
