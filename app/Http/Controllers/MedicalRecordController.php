<?php
// app/Http/Controllers/MedicalRecordController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Treatment;
use App\Models\TreatmentRecord;
use App\Models\MedicalRecordImage;
use Illuminate\Support\Facades\Storage;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $records = MedicalRecord::with(['patient', 'user'])
                                ->orderBy('examination_date', 'desc')
                                ->paginate(15);
        return view('medical-records.index', compact('records'));
    }

    public function create()
    {
        $patients = Patient::all();
        $treatments = Treatment::where('is_active', true)->get();
        return view('medical-records.create', compact('patients', 'treatments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'examination_date' => 'required|date',
            'chief_complaint' => 'required|string',
            'history_present_illness' => 'required|string',
            'clinical_examination' => 'required|string',
            'diagnosis' => 'required|string',
            'treatment_plan' => 'required|string',
            'treatment_performed' => 'required|string',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string',
            'tooth_chart' => 'nullable|array',
            'treatments' => 'nullable|array',
            'treatments.*.treatment_id' => 'required|exists:treatments,id',
            'treatments.*.tooth_number' => 'nullable|string',
            'treatments.*.quantity' => 'required|integer|min:1',
            'treatments.*.notes' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $validated['user_id'] = auth()->id();

        $medicalRecord = MedicalRecord::create($validated);

        // Save treatment records
        if ($request->has('treatments')) {
            foreach ($request->treatments as $treatmentData) {
                $treatment = Treatment::find($treatmentData['treatment_id']);
                TreatmentRecord::create([
                    'medical_record_id' => $medicalRecord->id,
                    'treatment_id' => $treatmentData['treatment_id'],
                    'tooth_number' => $treatmentData['tooth_number'] ?? null,
                    'quantity' => $treatmentData['quantity'],
                    'price' => $treatment->price,
                    'notes' => $treatmentData['notes'] ?? null,
                ]);
            }
        }

        // Save images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('medical-records', 'public');
                MedicalRecordImage::create([
                    'medical_record_id' => $medicalRecord->id,
                    'image_path' => $path,
                    'image_type' => $request->input("image_types.{$index}", 'clinical'),
                    'description' => $request->input("image_descriptions.{$index}"),
                ]);
            }
        }

        return redirect()->route('medical-records.index')->with('success', 'Rekam medis berhasil disimpan.');
    }

    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['patient', 'user', 'treatments.treatment', 'images']);
        return view('medical-records.show', compact('medicalRecord'));
    }

    public function edit(MedicalRecord $medicalRecord)
    {
        $patients = Patient::all();
        $treatments = Treatment::where('is_active', true)->get();
        $medicalRecord->load(['treatments.treatment', 'images']);
        return view('medical-records.edit', compact('medicalRecord', 'patients', 'treatments'));
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $validated = $request->validate([
            'examination_date' => 'required|date',
            'chief_complaint' => 'required|string',
            'history_present_illness' => 'required|string',
            'clinical_examination' => 'required|string',
            'diagnosis' => 'required|string',
            'treatment_plan' => 'required|string',
            'treatment_performed' => 'required|string',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string',
            'tooth_chart' => 'nullable|array',
        ]);

        $medicalRecord->update($validated);

        return redirect()->route('medical-records.show', $medicalRecord)
                        ->with('success', 'Rekam medis berhasil diperbarui.');
    }
}