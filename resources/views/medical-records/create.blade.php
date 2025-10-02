<!-- resources/views/medical-records/create.blade.php -->
@extends('layouts.app')

@section('title', 'Tambah Rekam Medis Baru')

@section('content')
<!-- PAGE HEADER -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-file-medical-alt me-2 text-primary"></i>
        Tambah Rekam Medis Baru
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('medical-records.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<!-- PROGRESS INDICATOR -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body">
                <div class="progress-steps">
                    <div class="step active" data-step="1">
                        <div class="step-icon"><i class="fas fa-user"></i></div>
                        <div class="step-label">Pasien</div>
                    </div>
                    <div class="step" data-step="2">
                        <div class="step-icon"><i class="fas fa-stethoscope"></i></div>
                        <div class="step-label">Pemeriksaan</div>
                    </div>
                    <div class="step" data-step="3">
                        <div class="step-icon"><i class="fas fa-pills"></i></div>
                        <div class="step-label">Tindakan</div>
                    </div>
                    <div class="step" data-step="4">
                        <div class="step-icon"><i class="fas fa-image"></i></div>
                        <div class="step-label">Gambar</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FORM -->
<form action="{{ route('medical-records.store') }}" method="POST" enctype="multipart/form-data" id="medicalRecordForm">
    @csrf
    
    <!-- STEP 1: PATIENT SELECTION -->
    <div class="form-step active" id="step-1">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- PILIH PASIEN -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-user me-2"></i>Pilih Pasien
                        </h6>
                    </div>
                    <div class="card-body">
                        <!-- Search Patient -->
                        <div class="mb-3">
                            <label for="patient_search" class="form-label">
                                Cari Pasien <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="text" 
                                       class="form-control form-control-lg" 
                                       id="patient_search" 
                                       placeholder="Ketik nama atau nomor pasien..."
                                       autocomplete="off">
                                <button class="btn btn-outline-secondary" type="button" id="clearPatientSearch">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div id="patient-search-results" class="list-group mt-2" style="display: none;"></div>
                        </div>

                        <!-- Hidden input for patient_id -->
                        <input type="hidden" name="patient_id" id="patient_id" value="{{ old('patient_id', request('patient_id')) }}">
                        
                        <!-- Selected Patient Display -->
                        <div id="selected-patient-card" style="display: none;">
                            <div class="card border-success">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="d-flex align-items-center flex-grow-1">
                                            <div class="patient-avatar-large me-3">
                                                <span id="patient-initial"></span>
                                            </div>
                                            <div id="patient-details">
                                                <!-- Patient details will be inserted here -->
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="changePatientBtn">
                                            <i class="fas fa-edit me-1"></i>Ganti
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @error('patient_id')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- TANGGAL PEMERIKSAAN -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-calendar-alt me-2"></i>Tanggal Pemeriksaan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="examination_date" class="form-label">
                                Tanggal Pemeriksaan <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   class="form-control @error('examination_date') is-invalid @enderror" 
                                   id="examination_date" 
                                   name="examination_date" 
                                   value="{{ old('examination_date', today()->format('Y-m-d')) }}" 
                                   required>
                            @error('examination_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="d-flex justify-content-between mb-4">
                    <a href="{{ route('medical-records.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="button" class="btn btn-primary next-step" data-next="2">
                        Lanjut <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- STEP 2: EXAMINATION DETAILS -->
    <div class="form-step" id="step-2" style="display: none;">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <!-- KELUHAN UTAMA -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-comment-medical me-2"></i>Keluhan Utama (Chief Complaint)
                        </h6>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control @error('chief_complaint') is-invalid @enderror" 
                                  id="chief_complaint" 
                                  name="chief_complaint" 
                                  rows="3" 
                                  required
                                  placeholder="Contoh: Sakit gigi pada rahang bawah kanan sejak 3 hari yang lalu">{{ old('chief_complaint') }}</textarea>
                        @error('chief_complaint')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- RIWAYAT PENYAKIT SEKARANG -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-history me-2"></i>Riwayat Penyakit Sekarang
                        </h6>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control @error('history_present_illness') is-invalid @enderror" 
                                  id="history_present_illness" 
                                  name="history_present_illness" 
                                  rows="4" 
                                  required
                                  placeholder="Jelaskan riwayat keluhan pasien, onset, durasi, faktor yang memperburuk/meringankan, dll.">{{ old('history_present_illness') }}</textarea>
                        @error('history_present_illness')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- PEMERIKSAAN KLINIS -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-user-md me-2"></i>Pemeriksaan Klinis
                        </h6>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control @error('clinical_examination') is-invalid @enderror" 
                                  id="clinical_examination" 
                                  name="clinical_examination" 
                                  rows="4" 
                                  required
                                  placeholder="Hasil pemeriksaan objektif: inspeksi, palpasi, perkusi, dll.">{{ old('clinical_examination') }}</textarea>
                        @error('clinical_examination')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- DIAGNOSIS -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-diagnoses me-2"></i>Diagnosis
                        </h6>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control @error('diagnosis') is-invalid @enderror" 
                                  id="diagnosis" 
                                  name="diagnosis" 
                                  rows="3" 
                                  required
                                  placeholder="Contoh: Karies profunda pada gigi 46, Pulpitis reversibel">{{ old('diagnosis') }}</textarea>
                        @error('diagnosis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- RENCANA PERAWATAN -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-tasks me-2"></i>Rencana Perawatan
                        </h6>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control @error('treatment_plan') is-invalid @enderror" 
                                  id="treatment_plan" 
                                  name="treatment_plan" 
                                  rows="3" 
                                  required
                                  placeholder="Rencana tindakan yang akan dilakukan">{{ old('treatment_plan') }}</textarea>
                        @error('treatment_plan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- TINDAKAN YANG DILAKUKAN -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-procedures me-2"></i>Tindakan Yang Dilakukan
                        </h6>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control @error('treatment_performed') is-invalid @enderror" 
                                  id="treatment_performed" 
                                  name="treatment_performed" 
                                  rows="3" 
                                  required
                                  placeholder="Tindakan yang telah dilakukan pada kunjungan ini">{{ old('treatment_performed') }}</textarea>
                        @error('treatment_performed')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- RESEP OBAT -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-prescription me-2"></i>Resep Obat (Opsional)
                        </h6>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control @error('prescription') is-invalid @enderror" 
                                  id="prescription" 
                                  name="prescription" 
                                  rows="3"
                                  placeholder="Contoh: Amoxicillin 500mg 3x1, Paracetamol 500mg 3x1">{{ old('prescription') }}</textarea>
                        @error('prescription')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- CATATAN TAMBAHAN -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-sticky-note me-2"></i>Catatan Tambahan (Opsional)
                        </h6>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" 
                                  name="notes" 
                                  rows="3"
                                  placeholder="Catatan atau informasi tambahan">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="d-flex justify-content-between mb-4">
                    <button type="button" class="btn btn-secondary prev-step" data-prev="1">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </button>
                    <button type="button" class="btn btn-primary next-step" data-next="3">
                        Lanjut <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- STEP 3: TREATMENTS -->
    <div class="form-step" id="step-3" style="display: none;">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-procedures me-2"></i>Daftar Tindakan Medis
                        </h6>
                        <button type="button" class="btn btn-sm btn-primary" id="addTreatmentBtn">
                            <i class="fas fa-plus me-1"></i>Tambah Tindakan
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="treatments-container">
                            <!-- Treatment items will be added here -->
                        </div>
                        
                        <div class="text-center py-4" id="no-treatments-message">
                            <i class="fas fa-procedures fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada tindakan ditambahkan</p>
                            <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('addTreatmentBtn').click()">
                                <i class="fas fa-plus me-2"></i>Tambah Tindakan Pertama
                            </button>
                        </div>

                        <!-- Total Cost -->
                        <div class="card border-primary mt-3" id="total-cost-card" style="display: none;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Total Biaya:</h5>
                                    <h4 class="mb-0 text-primary" id="total-cost">Rp 0</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="d-flex justify-content-between mb-4">
                    <button type="button" class="btn btn-secondary prev-step" data-prev="2">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </button>
                    <button type="button" class="btn btn-primary next-step" data-next="4">
                        Lanjut <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- STEP 4: IMAGES -->
    <div class="form-step" id="step-4" style="display: none;">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-images me-2"></i>Upload Gambar (Opsional)
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Upload Foto X-Ray, Intraoral, atau Gambar Klinis</label>
                            <input type="file" 
                                   class="form-control" 
                                   id="images" 
                                   name="images[]" 
                                   multiple 
                                   accept="image/*">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Anda dapat upload multiple gambar. Format: JPG, PNG. Max 2MB per file.
                            </small>
                        </div>

                        <!-- Image Preview -->
                        <div id="image-preview" class="row g-3 mt-3"></div>
                    </div>
                </div>

                <!-- Final Review Card -->
                <div class="card shadow mb-4 border-success">
                    <div class="card-header bg-success text-white py-3">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-check-circle me-2"></i>Review & Submit
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">
                            <i class="fas fa-info-circle me-2 text-info"></i>
                            Pastikan semua data yang diinput sudah benar sebelum menyimpan.
                        </p>
                        <div class="alert alert-warning">
                            <strong><i class="fas fa-exclamation-triangle me-2"></i>Perhatian:</strong>
                            Data rekam medis yang sudah disimpan tidak dapat dihapus, hanya bisa diedit.
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="d-flex justify-content-between mb-4">
                    <button type="button" class="btn btn-secondary prev-step" data-prev="3">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </button>
                    <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
                        <i class="fas fa-save me-2"></i>Simpan Rekam Medis
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('styles')
<style>
    /* Progress Steps */
    .progress-steps {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        padding: 0 20px;
    }
    
    .progress-steps::before {
        content: '';
        position: absolute;
        top: 25px;
        left: 20%;
        right: 20%;
        height: 2px;
        background: #e9ecef;
        z-index: 0;
    }
    
    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 1;
    }
    
    .step-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .step.active .step-icon {
        background: #007bff;
        color: white;
        box-shadow: 0 0 0 4px rgba(0,123,255,0.2);
    }
    
    .step.completed .step-icon {
        background: #28a745;
        color: white;
    }
    
    .step-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #6c757d;
    }
    
    .step.active .step-label {
        color: #007bff;
        font-weight: 600;
    }
    
    /* Patient Avatar */
    .patient-avatar-large {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        font-weight: bold;
    }
    
    /* Search Results */
    #patient-search-results {
        max-height: 300px;
        overflow-y: auto;
        position: absolute;
        z-index: 1000;
        width: calc(100% - 24px);
    }
    
    .list-group-item {
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .list-group-item:hover {
        background-color: #f8f9fa;
        border-left: 3px solid #007bff;
    }
    
    /* Treatment Item */
    .treatment-item {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        transition: all 0.2s ease;
    }
    
    .treatment-item:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    /* Image Preview */
    .image-preview-item {
        position: relative;
    }
    
    .image-preview-item img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 8px;
    }
    
    .remove-image-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(220, 53, 69, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    
    @media (max-width: 768px) {
        .progress-steps {
            flex-direction: column;
        }
        
        .progress-steps::before {
            display: none;
        }
        
        .step {
            margin-bottom: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
let treatments = [];
let treatmentsList = [];
let selectedPatient = null;
let treatmentIndex = 0;

document.addEventListener('DOMContentLoaded', function() {
    // Load treatments list
    loadTreatments();
    
    // Initialize patient search
    initializePatientSearch();
    
    // Initialize step navigation
    initializeStepNavigation();
    
    // Initialize treatment management
    initializeTreatmentManagement();
    
    // Initialize image upload
    initializeImageUpload();
    
    // Form submission
    document.getElementById('medicalRecordForm').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
    });
});

function initializePatientSearch() {
    const searchInput = document.getElementById('patient_search');
    const clearBtn = document.getElementById('clearPatientSearch');
    const changeBtn = document.getElementById('changePatientBtn');
    
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        if (query.length < 2) {
            document.getElementById('patient-search-results').style.display = 'none';
            return;
        }
        
        searchTimeout = setTimeout(() => {
            searchPatients(query);
        }, 300);
    });
    
    clearBtn.addEventListener('click', function() {
        searchInput.value = '';
        document.getElementById('patient-search-results').style.display = 'none';
    });
    
    changeBtn.addEventListener('click', function() {
        document.getElementById('selected-patient-card').style.display = 'none';
        document.getElementById('patient_id').value = '';
        searchInput.value = '';
        searchInput.focus();
    });
}

function searchPatients(query) {
    fetch(`/api/patients?search=${query}`)
        .then(response => response.json())
        .then(data => {
            displayPatientResults(data);
        });
}

function displayPatientResults(patients) {
    const resultsDiv = document.getElementById('patient-search-results');
    
    if (patients.length === 0) {
        resultsDiv.innerHTML = '<div class="list-group-item text-center text-muted">Tidak ada pasien ditemukan</div>';
        resultsDiv.style.display = 'block';
        return;
    }
    
    let html = '';
    patients.forEach(patient => {
        html += `
            <div class="list-group-item list-group-item-action" onclick='selectPatient(${JSON.stringify(patient)})'>
                <div class="d-flex align-items-center">
                    <div class="patient-avatar-large me-3" style="width: 40px; height: 40px; font-size: 1rem;">
                        ${patient.name.substring(0, 1).toUpperCase()}
                    </div>
                    <div class="flex-grow-1">
                        <strong>${patient.name}</strong>
                        <br>
                        <small class="text-muted">
                            ${patient.patient_number} • ${patient.age} tahun • ${patient.phone}
                        </small>
                    </div>
                </div>
            </div>
        `;
    });
    
    resultsDiv.innerHTML = html;
    resultsDiv.style.display = 'block';
}

function selectPatient(patient) {
    selectedPatient = patient;
    document.getElementById('patient_id').value = patient.id;
    document.getElementById('patient-search-results').style.display = 'none';
    document.getElementById('patient_search').value = patient.name;
    
    document.getElementById('patient-initial').textContent = patient.name.substring(0, 1).toUpperCase();
    document.getElementById('patient-details').innerHTML = `
        <h5 class="mb-1">${patient.name}</h5>
        <p class="mb-1">
            <span class="badge bg-secondary">${patient.patient_number}</span>
            <span class="ms-2">${patient.gender === 'L' ? 'Laki-laki' :