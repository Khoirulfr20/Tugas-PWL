<?php
// app/Models/MedicalRecordImage.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecordImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_record_id', 'image_path', 'image_type', 'description'
    ];

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }
}
