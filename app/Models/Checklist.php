<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    protected $table = 'checklists';

    protected $fillable = [
        'processo_id',
        'approved',
        'message'
    ];

    protected $casts = [
        'approved' => 'boolean'
    ];

    public function processo()
    {
        return $this->belongsTo(Processo::class);
    }
}
