<!-- resources/views/patients/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Edit Data Pasien - ' . $patient->name)

@section('content')
<!-- PAGE HEADER -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user-edit me-2 text-primary"></i>
        Edit Data Pasien
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('patients.show', $patient) }}" class="btn btn-info">
                <i class="fas fa-eye me-1"></i>Lihat Detail
            </a>
        </div>
        <a href="{{ route('patients.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<!-- PATIENT INFO CARD -->
<div class="row mb-4">
    <div class="col-lg-10 mx-auto">
        <div class="alert alert-info">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle fa-2x me-3"></i>
                <div>
                    <strong>Edit Data Pasien:</strong> {{ $patient->name }}
                    <br>
                    <small>No. Pasien: <span class="badge bg-secondary">{{ $patient->patient_number }}</span></small>
                    <small class="ms-2">Terdaftar: {{ $patient->created_at->format('d M Y') }}</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FORM CARD -->
<div class="row">
    <div class="col-lg-10 mx-auto">
        <form action="{{ route('patients.update', $patient) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- DATA PRIBADI -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user me-2"></i>Data Pribadi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Nomor Pasien (Read Only) -->
                        <div class="col-md-6 mb-3">
                            <label for="patient_number" class="form-label">
                                Nomor Pasien
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="patient_number" 
                                   value="{{ $patient->patient_number }}" 
                                   readonly
                                   style="background-color: #e9ecef;">
                            <small class="text-muted">Nomor pasien tidak dapat diubah</small>
                        </div>

                        <!-- Tanggal Daftar (Read Only) -->
                        <div class="col-md-6 mb-3">
                            <label for="registered_date" class="form-label">
                                Tanggal Terdaftar
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="registered_date" 
                                   value="{{ $patient->created_at->format('d F Y') }}" 
                                   readonly
                                   style="background-color: #e9ecef;">
                            <small class="text-muted">{{ $patient->created_at->diffForHumans() }}</small>
                        </div>

                        <!-- Nama Lengkap -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $patient->name) }}" 
                                   required
                                   placeholder="Masukkan nama lengkap">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="col-md-6 mb-3">
                            <label for="birth_date" class="form-label">
                                Tanggal Lahir <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   class="form-control @error('birth_date') is-invalid @enderror" 
                                   id="birth_date" 
                                   name="birth_date" 
                                   value="{{ old('birth_date', $patient->birth_date->format('Y-m-d')) }}" 
                                   required>
                            @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Umur saat ini: <strong id="current-age">{{ $patient->age }} tahun</strong>
                            </small>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Jenis Kelamin <span class="text-danger">*</span>
                            </label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="gender" 
                                           id="genderL" 
                                           value="L" 
                                           {{ old('gender', $patient->gender) === 'L' ? 'checked' : '' }}
                                           required>
                                    <label class="form-check-label" for="genderL">
                                        <i class="fas fa-mars text-primary"></i> Laki-laki
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="gender" 
                                           id="genderP" 
                                           value="P" 
                                           {{ old('gender', $patient->gender) === 'P' ? 'checked' : '' }}
                                           required>
                                    <label class="form-check-label" for="genderP">
                                        <i class="fas fa-venus text-danger"></i> Perempuan
                                    </label>
                                </div>
                            </div>
                            @error('gender')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nomor Telepon -->
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">
                                Nomor Telepon <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', $patient->phone) }}" 
                                   required
                                   placeholder="08123456789">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div class="col-12 mb-3">
                            <label for="address" class="form-label">
                                Alamat Lengkap <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" 
                                      name="address" 
                                      rows="3" 
                                      required
                                      placeholder="Masukkan alamat lengkap">{{ old('address', $patient->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- KONTAK DARURAT -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-phone-alt me-2"></i>Kontak Darurat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Nama Kontak Darurat -->
                        <div class="col-md-6 mb-3">
                            <label for="emergency_contact_name" class="form-label">
                                Nama Kontak Darurat
                            </label>
                            <input type="text" 
                                   class="form-control @error('emergency_contact_name') is-invalid @enderror" 
                                   id="emergency_contact_name" 
                                   name="emergency_contact_name" 
                                   value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}"
                                   placeholder="Nama keluarga/teman">
                            @error('emergency_contact_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Telepon Kontak Darurat -->
                        <div class="col-md-6 mb-3">
                            <label for="emergency_contact_phone" class="form-label">
                                Telepon Kontak Darurat
                            </label>
                            <input type="text" 
                                   class="form-control @error('emergency_contact_phone') is-invalid @enderror" 
                                   id="emergency_contact_phone" 
                                   name="emergency_contact_phone" 
                                   value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}"
                                   placeholder="08123456789">
                            @error('emergency_contact_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIWAYAT MEDIS -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-notes-medical me-2"></i>Riwayat Medis
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Riwayat Penyakit -->
                        <div class="col-md-6 mb-3">
                            <label for="medical_history" class="form-label">
                                Riwayat Penyakit
                            </label>
                            <textarea class="form-control @error('medical_history') is-invalid @enderror" 
                                      id="medical_history" 
                                      name="medical_history" 
                                      rows="4"
                                      placeholder="Diabetes, hipertensi, jantung, dll.">{{ old('medical_history', $patient->medical_history) }}</textarea>
                            @error('medical_history')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Kosongkan jika tidak ada</small>
                        </div>

                        <!-- Alergi -->
                        <div class="col-md-6 mb-3">
                            <label for="allergies" class="form-label">
                                Alergi
                            </label>
                            <textarea class="form-control @error('allergies') is-invalid @enderror" 
                                      id="allergies" 
                                      name="allergies" 
                                      rows="4"
                                      placeholder="Alergi obat, makanan, dll.">{{ old('allergies', $patient->allergies) }}</textarea>
                            @error('allergies')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Kosongkan jika tidak ada</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CHANGE LOG -->
            <div class="card shadow mb-4 border-warning">
                <div class="card-header bg-warning text-dark py-3">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-history me-2"></i>Informasi Perubahan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Dibuat Pada:</small>
                            <strong>{{ $patient->created_at->format('d F Y, H:i') }}</strong>
                            <br>
                            <small class="text-muted">{{ $patient->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Terakhir Diubah:</small>
                            <strong>{{ $patient->updated_at->format('d F Y, H:i') }}</strong>
                            <br>
                            <small class="text-muted">{{ $patient->updated_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FORM ACTIONS -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('patients.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <a href="{{ route('patients.show', $patient) }}" class="btn btn-info ms-2">
                                <i class="fas fa-eye me-2"></i>Lihat Detail
                            </a>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Update Data Pasien
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- DANGER ZONE -->
        <div class="card shadow mb-4 border-danger">
            <div class="card-header bg-danger text-white py-3">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-exclamation-triangle me-2"></i>Danger Zone
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Hapus Pasien</strong>
                        <p class="text-muted mb-0">
                            Menghapus pasien akan menghapus semua data rekam medis dan antrian terkait. 
                            <strong>Tindakan ini tidak dapat dibatalkan!</strong>
                        </p>
                    </div>
                    <form action="{{ route('patients.destroy', $patient) }}" 
                          method="POST" 
                          onsubmit="return confirmDelete()">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt me-2"></i>Hapus Pasien
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .alert-info {
        border-left: 4px solid #0dcaf0;
    }
    
    .card.border-warning {
        border-width: 2px !important;
    }
    
    .card.border-danger {
        border-width: 2px !important;
    }
    
    .form-control:read-only {
        cursor: not-allowed;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Calculate age automatically when birth date changes
    const birthDateInput = document.getElementById('birth_date');
    const currentAgeSpan = document.getElementById('current-age');
    
    birthDateInput.addEventListener('change', function() {
        const birthDate = new Date(this.value);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        
        if (age >= 0 && age <= 150) {
            currentAgeSpan.textContent = age + ' tahun';
        }
    });

    // Phone number validation (only numbers)
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    const emergencyPhoneInput = document.getElementById('emergency_contact_phone');
    emergencyPhoneInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Highlight changed fields
    const formInputs = document.querySelectorAll('input[type="text"], input[type="date"], textarea, input[type="radio"]');
    const originalValues = {};
    
    formInputs.forEach(input => {
        if (input.type === 'radio') {
            originalValues[input.name] = input.checked;
        } else {
            originalValues[input.id] = input.value;
        }
        
        input.addEventListener('change', function() {
            let isChanged = false;
            
            if (this.type === 'radio') {
                isChanged = originalValues[this.name] !== this.checked;
            } else {
                isChanged = originalValues[this.id] !== this.value;
            }
            
            if (isChanged) {
                this.style.borderColor = '#ffc107';
                this.style.backgroundColor = '#fff3cd';
            } else {
                this.style.borderColor = '';
                this.style.backgroundColor = '';
            }
        });
    });
});

function confirmDelete() {
    const patientName = '{{ $patient->name }}';
    const medicalRecordsCount = {{ $patient->medicalRecords->count() }};
    const queuesCount = {{ $patient->queues->count() }};
    
    let message = `Apakah Anda yakin ingin menghapus pasien "${patientName}"?\n\n`;
    message += `Data yang akan terhapus:\n`;
    message += `- ${medicalRecordsCount} rekam medis\n`;
    message += `- ${queuesCount} riwayat antrian\n\n`;
    message += `TINDAKAN INI TIDAK DAPAT DIBATALKAN!`;
    
    return confirm(message);
}
</script>
@endpush