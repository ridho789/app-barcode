<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    protected $table = 'tbl_trackings';
    protected $primaryKey = 'id_tracking';

    protected $fillable = [
        'id_marking_header',
        'id_user',
        'status',
    ];
}
