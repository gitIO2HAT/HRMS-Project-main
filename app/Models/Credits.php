<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credits extends Model
{
    use HasFactory;
    public $table = 'credits_balance';
    protected $fillable = [
        'vacation_leave',
        'sick_leave',
        'special_previlege_leave',
        'maternity_leave',
        'paternity_leave',
        'solo_parent_leave',
        'study_leave',
        'vawc_leave',
        'rehabilitation_leave',
        'special_leave_benefits_for_women',
        'special_emergency_leave',
        'monetization_leave',
        'terminal_leave',
        'adoption_leave'
    ];
}
