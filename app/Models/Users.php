<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    protected $table = 'users';
    const UPDATED_AT = false;
    public $timestamps = false;
    // protected $searchable = [
    //     'id',
    //     'Ma',
    //     'HoTen',
    //     'Sdt',
    //     'DiaChi',
    //     'Email'
    // ];
}
