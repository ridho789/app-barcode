<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipper extends Model
{
    use HasFactory;
    protected $table = 'tbl_shippers';
    protected $primaryKey = 'id_shipper';

    protected $fillable = [
        'name',
        'code_mark',
        'id_history'
    ];
}
