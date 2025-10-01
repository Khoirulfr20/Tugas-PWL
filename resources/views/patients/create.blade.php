<!-- resources/views/patients/create.blade.php -->
@extends('layouts.app')

@section('title', 'Tambah Pasien Baru')

@section('content')
<!-- PAGE HEADER -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user-plus me-2 text-primary"></i>
        Tambah Pasien Baru
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('patients.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<!-- FORM CARD -->
<div class="row">
    <div class="col-lg-10 mx-auto">
        <form action="{{ route('patients.store') }}" method="POST">
            @csrf
            
            <!-- DATA PRIBADI -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user me-2"></i>Data Pribadi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Nama Lengkap -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
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
                                   value="{{ old('birth_date') }}" 
                                   required>
                            @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Umur akan dihitung otomatis</small>
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
                                           {{ old('gender') === 'L' ? 'checked' : '' }}
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
                                           {{ old('gender') === 'P' ? 'checked' : '' }}
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
                                   value="{{ old('phone') }}" 
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
                                      placeholder="Masukkan alamat lengkap">{{ old('address') }}</textarea>
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
                                   value="{{ old('emergency_contact_name') }}"
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
                                   value="{{ old('emergency_contact_phone') }}"
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
                                      placeholder="Diabetes, hipertensi, jantung, dll.">{{ old('medical_history') }}</textarea>
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
                                      placeholder="Alergi obat, makanan, dll.">{{ old('allergies') }}</textarea>
                            @error('allergies')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Kosongkan jika tidak ada</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FORM ACTIONS -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('patients.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Data Pasien
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Calculate age automatically
    const birthDateInput = document.getElementById('birth_date');
    
    birthDateInput.addEventListener('change', function() {
        const birthDate = new Date(this.value);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        
        if (age >= 0) {
            console.log('Umur pasien:', age, 'tahun');
        }
    });

    // Phone number validation
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    const emergencyPhoneInput = document.getElementById('emergency_contact_phone');
    emergencyPhoneInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
});
</script>
@endpush