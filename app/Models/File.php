<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $table = 'files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'processo_id',
        'path',
        'filename',
        'type'
    ];

    public function processo ()
    {
        return $this->belongsTo(Processo::class);
    }
}
