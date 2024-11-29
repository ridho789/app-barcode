<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkingDetail extends Model
{
    use HasFactory;
    protected $table = 'tbl_marking_details';
    protected $primaryKey = 'id_marking_detail';

    protected $fillable = [
        'id_marking_header',
        'id_customer',
        'id_unit',
        'inner_marking',
        'weight',
        'qty',
        'note'
    ];
}
