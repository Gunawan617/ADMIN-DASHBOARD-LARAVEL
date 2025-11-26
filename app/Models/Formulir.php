<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulir extends Model
{
    use HasFactory;

    protected $table = 'formulir';

    protected $fillable = [
        'nama',
        'email',
        'whatsapp',
        'jenis_program',
        'team_member_id',
        'pesan',
        'status',
    ];

    public function teamMember()
    {
        return $this->belongsTo(TeamMember::class);
    }

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
