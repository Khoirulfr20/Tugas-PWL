<?php
// app/Models/MedicalRecord.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id', 'user_id', 'examination_date', 'chief_complaint',
        'history_present_illness', 'clinical_examination', 'diagnosis',
        'treatment_plan', 'treatment_performed', 'prescription', 'notes', 'tooth_chart'
    ];

    protected $casts = [
        'examination_date' => 'datetime',
        'tooth_chart' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(MedicalRecordImage::class);
    }

    public function treatments()
    {
        return $this->hasMany(TreatmentRecord::class);
    }

    public function getTotalCostAttribute()
    {
        return $this->treatments->sum(function ($treatment) {
            return $treatment->price * $treatment->quantity;
        });
    }
}