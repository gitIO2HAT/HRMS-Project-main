<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    // Define the table name if it's not the plural form of the model name
    // protected $table = 'leaves'; // Uncomment this line if the table name is different

    protected $fillable = [
        'employee_id',
        'from',
        'to',
        'reason',
        'deleted',
        'status',     // Ensure this column exists in your database
        'leave_type',
        'leave_days', 
    ];

    /**
     * Get the user associated with the leave.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id', 'custom_id');
    }

    
    static public function getID($id)
    {
        return self::find($id);
    }

}
