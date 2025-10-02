<!-- resources/views/medical-records/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Edit Rekam Medis')

@section('content')
<!-- PAGE HEADER -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-edit me-2 text-primary"></i>
        Edit Rekam Medis
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('medical-records.show', $medicalRecord) }}" class="btn btn-info me-2">
            <i class="fas fa-eye me-1"></i>Lihat Detail
        </a>
        <a href="{{ route('medical-records.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<!-- PATIENT INFO BANNER -->
<div class="row mb-4">
    <div class="col-lg-10 mx-auto">
        <div class="alert alert-info">
            <div class="d-flex align-items-center">
                <i class="fas fa-user-circle fa-3x me-3"></i>
                <div>
                    <strong>Pasien:</strong> {{ $medicalRecord->patient->name }}
                    <br>
                    <small>
                        <span class="badge bg-secondary">{{ $medicalRecord->patient->patient_number }}</span>
                        <span class="ms-2">Tanggal Pemeriksaan: {{ $medicalRecord->examination_date->format('d F Y') }}</span>
                        <span class="ms-2">Dokter: {{ $medicalRecord->user->name }}</span>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FORM -->
<form action="{{ route('medical-records.update', $medicalRecord) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <!-- TANGGAL PEMERIKSAAN -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-calendar-alt me-2"></i>Tanggal Pemeriksaan
                    </h6>
                </div>
                <div class="card-body">
                    <input type="date" 
                           class="form-control @error('examination_date') is-invalid @enderror" 
                           name="examination_date" 
                           value="{{ old('examination_date', $medicalRecord->examination_date->format('Y-m-d')) }}" 
                           required>
                    @error('examination_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- KELUHAN UTAMA -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-comment-medical me-2"></i>Keluhan Utama
                    </h6>
                </div>
                <div class="card-body">
                    <textarea class="form-control @error('chief_complaint') is-invalid @enderror" 
                              name="chief_complaint" 
                              rows="3" 
                              required>{{ old('chief_complaint', $medicalRecord->chief_complaint) }}</textarea>
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
                              name="history_present_illness" 
                              rows="4" 
                              required>{{ old('history_present_illness', $medicalRecord->history_present_illness) }}</textarea>
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
                              name="clinical_examination" 
                              rows="4" 
                              required>{{ old('clinical_examination', $medicalRecord->clinical_examination) }}</textarea>
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
                              name="diagnosis" 
                              rows="3" 
                              required>{{ old('diagnosis', $medicalRecord->diagnosis) }}</textarea>
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
                              name="treatment_plan" 
                              rows="3" 
                              required>{{ old('treatment_plan', $medicalRecord->treatment_plan) }}</textarea>
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
                              name="treatment_performed" 
                              rows="3" 
                              required>{{ old('treatment_performed', $medicalRecord->treatment_performed) }}</textarea>
                    @error('treatment_performed')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- RESEP OBAT -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-prescription me-2"></i>Resep Obat
                    </h6>
                </div>
                <div class="card-body">
                    <textarea class="form-control @error('prescription') is-invalid @enderror" 
                              name="prescription" 
                              rows="3">{{ old('prescription', $medicalRecord->prescription) }}</textarea>
                    @error('prescription')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- CATATAN TAMBAHAN -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-sticky-note me-2"></i>Catatan Tambahan
                    </h6>
                </div>
                <div class="card-body">
                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                              name="notes" 
                              rows="3">{{ old('notes', $medicalRecord->notes) }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- EXISTING IMAGES -->
            @if($medicalRecord->images->count() > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-images me-2"></i>Gambar Yang Ada
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($medicalRecord->images as $image)
                        <div class="col-md-3">
                            <div class="card">
                                <img src="{{ Storage::url($image->image_path) }}" class="card-img-top" alt="Medical Image">
                                <div class="card-body p-2">
                                    <small class="text-muted">{{ $image->image_type }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <small class="text-muted mt-2 d-block">
                        <i class="fas fa-info-circle me-1"></i>
                        Upload gambar baru di bawah jika ingin menambah gambar
                    </small>
                </div>
            </div>
            @endif

            <!-- FORM ACTIONS -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('medical-records.show', $medicalRecord) }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Update Rekam Medis
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection