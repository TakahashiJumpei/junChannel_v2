<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
  use HasFactory;

  protected $fillable = ['creater_id', 'name', 'explanation', 'category_id'];
}
