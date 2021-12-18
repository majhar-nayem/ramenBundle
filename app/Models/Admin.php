<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class Admin extends Authenticatable
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $guarded = ['id','created_at'];
}
