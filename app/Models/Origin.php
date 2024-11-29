<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Origin extends Model
{
    use HasFactory;
    protected $table = 'tbl_origins';
    protected $primaryKey = 'id_origin';

    protected $fillable = [
        'name',
        'id_history'
    ];
}
