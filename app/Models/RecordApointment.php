<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordApointment extends Model
{
    use HasFactory;
    protected $table = "record_apointment";
    public $timestamps = false;
}
