<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'tbl_customers';
    protected $primaryKey = 'id_customer';

    protected $fillable = [
        'name',
        'address',
        'code_mark',
        'id_history',
    ];
}
