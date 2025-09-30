<?php
// app/Models/Queue.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id', 'queue_date', 'queue_number', 'status',
        'complaint', 'called_at', 'completed_at'
    ];

    protected $casts = [
        'queue_date' => 'date',
        'called_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('queue_date', today());
    }

    public function scopeWaiting($query)
    {
        return $query->where('status', 'waiting');
    }
}
