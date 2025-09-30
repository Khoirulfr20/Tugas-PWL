<?php
// app/Models/TreatmentRecord.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_record_id', 'treatment_id', 'tooth_number', 
        'quantity', 'price', 'notes'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

    public function getTotalPriceAttribute()
    {
        return $this->price * $this->quantity;
    }
}