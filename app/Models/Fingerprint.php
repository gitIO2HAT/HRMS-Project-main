<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fingerprint extends Model
{
    use HasFactory;

    public $table = 'fingerprint_id';
    protected $fillable = [
        'user_id',
        'fingerprint_id', 
        'status'
    ];

    public function fingerprint_id(){

        return $this->belongsTo(User::class, 'user_id', 'custom_id');
    }
}
