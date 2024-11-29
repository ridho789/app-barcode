<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkingHeader extends Model
{
    use HasFactory;
    protected $table = 'tbl_marking_headers';
    protected $primaryKey = 'id_marking_header';

    protected $fillable = [
        'id_shipper',
        'outer_marking',
        'date',
        'via',
        'vessel_sin',
        'qty_koli',
        'note',
        'is_printed',
        'printcount'
    ];

    public function markingDetails() {
        return $this->hasMany(MarkingDetail::class, 'id_marking_header');
    }
    
}
