<?php
// app/Models/Patient.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_number', 'name', 'birth_date', 'gender', 'address',
        'phone', 'emergency_contact_name', 'emergency_contact_phone',
        'medical_history', 'allergies'
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function getAgeAttribute()
    {
        return $this->birth_date->diffInYears(now());
    }

    public function queues()
    {
        return $this->hasMany(Queue::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function latestMedicalRecord()
    {
        return $this->hasOne(MedicalRecord::class)->latest();
    }
}
