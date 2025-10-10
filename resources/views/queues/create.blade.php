<!-- resources/views/queues/create.blade.php -->
@extends('layouts.app')

@section('title', 'Tambah Antrian Baru')

@section('content')
<!-- PAGE HEADER -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-plus-circle me-2 text-primary"></i>
        Tambah Antrian Baru
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('queues.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<!-- FORM CARD -->
<div class="row">
    <div class="col-lg-8 mx-auto">
        <form action="{{ route('queues.store') }}" method="POST" id="queueForm">
            @csrf
            
            <!-- INFO ANTRIAN -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-calendar-alt me-2"></i>Informasi Antrian
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Tanggal Antrian -->
                    <div class="mb-3">
                        <label for="queue_date" class="form-label">
                            Tanggal Antrian <span class="text-danger">*</span>
                        </label>
                        <input type="date" 
                               class="form-control @error('queue_date') is-invalid @enderror" 
                               id="queue_date" 
                               name="queue_date" 
                               value="{{ old('queue_date', request('date', today()->format('Y-m-d'))) }}" 
                               required>
                        @error('queue_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Nomor antrian akan digenerate otomatis
                        </small>
                    </div>

                    <!-- Preview Nomor Antrian -->
                    <div class="alert alert-info mb-0">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-list-ol fa-2x me-3"></i>
                            <div>
                                <strong>Nomor Antrian Berikutnya:</strong>
                                <br>
                                <span class="fs-4 text-primary" id="next-queue-number">
                                    <span class="spinner-border spinner-border-sm"></span> Loading...
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PILIH PASIEN -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user me-2"></i>Pilih Pasien
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Search Pasien -->
                    <div class="mb-3">
                        <label for="patient_search" class="form-label">
                            Cari Pasien <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="text" 
                                   class="form-control" 
                                   id="patient_search" 
                                   placeholder="Ketik nama atau nomor pasien..."
                                   autocomplete="off">
                            <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div id="search-results" class="list-group mt-2" style="display: none;"></div>
                    </div>

                    <!-- Selected Patient Display -->
                    <input type="hidden" name="patient_id" id="patient_id" value="{{ old('patient_id', request('patient_id')) }}">
                    
                    <div id="selected-patient" style="display: none;">
                        <div class="alert alert-success">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle fa-2x me-3"></i>
                                    <div id="patient-info">
                                        <!-- Patient info will be inserted here -->
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger" id="changePatient">
                                    <i class="fas fa-edit me-1"></i>Ganti Pasien
                                </button>
                            </div>
                        </div>
                    </div>

                    @error('patient_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <!-- Quick Link -->
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            Pasien belum terdaftar? 
                            <a href="{{ route('patients.create') }}" target="_blank" class="text-primary">
                                <i class="fas fa-plus-circle me-1"></i>Daftar Pasien Baru
                            </a>
                        </small>
                    </div>
                </div>
            </div>

            <!-- KELUHAN -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-notes-medical me-2"></i>Keluhan Pasien
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="complaint" class="form-label">
                            Keluhan (Opsional)
                        </label>
                        <textarea class="form-control @error('complaint') is-invalid @enderror" 
                                  id="complaint" 
                                  name="complaint" 
                                  rows="4"
                                  placeholder="Masukkan keluhan atau catatan khusus untuk antrian ini...">{{ old('complaint') }}</textarea>
                        @error('complaint')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Keluhan ini akan membantu dokter dalam persiapan pemeriksaan
                        </small>
                    </div>
                </div>
            </div>

            <!-- FORM ACTIONS -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('queues.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-save me-2"></i>Simpan Antrian
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    #search-results {
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
    
    .patient-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
    }
</style>
@endpush

@push('scripts')
<script>
let selectedPatientId = '{{ old("patient_id", request("patient_id")) }}';

document.addEventListener('DOMContentLoaded', function() {
    const queueDateInput = document.getElementById('queue_date');
    const patientSearchInput = document.getElementById('patient_search');
    const searchResults = document.getElementById('search-results');
    const selectedPatientDiv = document.getElementById('selected-patient');
    const patientIdInput = document.getElementById('patient_id');
    const clearSearchBtn = document.getElementById('clearSearch');
    const changePatientBtn = document.getElementById('changePatient');
    const submitBtn = document.getElementById('submitBtn');

    // Load next queue number
    loadNextQueueNumber(queueDateInput.value);

    // Update queue number when date changes
    queueDateInput.addEventListener('change', function() {
        loadNextQueueNumber(this.value);
    });

    // Patient search
    let searchTimeout;
    patientSearchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();

        if (query.length < 2) {
            searchResults.style.display = 'none';
            return;
        }

        searchTimeout = setTimeout(() => {
            fetch(`/api/patients?search=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    displaySearchResults(data);
                })
                .catch(error => {
                    console.error('Error searching patients:', error);
                });
        }, 300);
    });

    // Clear search
    clearSearchBtn.addEventListener('click', function() {
        patientSearchInput.value = '';
        searchResults.style.display = 'none';
    });

    // Change patient
    changePatientBtn.addEventListener('click', function() {
        selectedPatientDiv.style.display = 'none';
        patientSearchInput.value = '';
        patientIdInput.value = '';
        patientSearchInput.focus();
    });

    // Form validation
    document.getElementById('queueForm').addEventListener('submit', function(e) {
        if (!patientIdInput.value) {
            e.preventDefault();

function loadNextQueueNumber(date) {
    fetch(`/api/queues/next-number?date=${date}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('next-queue-number').innerHTML = 
                `<strong class="fs-3">${data.next_number}</strong>`;
        })
        .catch(error => {
            document.getElementById('next-queue-number').textContent = 'Error loading';
        });
}

function loadPatients() {
    fetch('/api/patients')
        .then(response => response.json())
        .then(data => {
            patients = data;
        })
        .catch(error => {
            console.error('Error loading patients:', error);
        });
}

function displaySearchResults(results) {
    const searchResults = document.getElementById('search-results');
    
    if (results.length === 0) {
        searchResults.innerHTML = `
            <div class="list-group-item text-center text-muted">
                <i class="fas fa-search me-2"></i>Tidak ada pasien ditemukan
            </div>
        `;
        searchResults.style.display = 'block';
        return;
    }

    let html = '';
    results.forEach(patient => {
        html += `
            <div class="list-group-item list-group-item-action" onclick="selectPatient(${JSON.stringify(patient).replace(/"/g, '&quot;')})">
                <div class="d-flex align-items-center">
                    <div class="patient-avatar me-3">
                        ${patient.name.substring(0, 1).toUpperCase()}
                    </div>
                    <div class="flex-grow-1">
                        <strong>${patient.name}</strong>
                        <br>
                        <small class="text-muted">
                            <span class="badge bg-secondary">${patient.patient_number}</span>
                            <i class="fas fa-phone ms-2 me-1"></i>${patient.phone}
                            <i class="fas fa-${patient.gender === 'L' ? 'mars' : 'venus'} ms-2 me-1"></i>
                            ${patient.age} tahun
                        </small>
                    </div>
                    <i class="fas fa-chevron-right text-muted"></i>
                </div>
            </div>
        `;
    });

    searchResults.innerHTML = html;
    searchResults.style.display = 'block';
}

function selectPatient(patient) {
    const patientIdInput = document.getElementById('patient_id');
    const selectedPatientDiv = document.getElementById('selected-patient');
    const patientInfo = document.getElementById('patient-info');
    const searchResults = document.getElementById('search-results');
    const patientSearchInput = document.getElementById('patient_search');

    patientIdInput.value = patient.id;
    
    patientInfo.innerHTML = `
        <div>
            <strong class="fs-5">${patient.name}</strong>
            <br>
            <span class="badge bg-secondary">${patient.patient_number}</span>
            <span class="ms-2">
                <i class="fas fa-${patient.gender === 'L' ? 'mars' : 'venus'} me-1"></i>
                ${patient.gender === 'L' ? 'Laki-laki' : 'Perempuan'}, ${patient.age} tahun
            </span>
            <span class="ms-2">
                <i class="fas fa-phone me-1"></i>${patient.phone}
            </span>
        </div>
    `;

    selectedPatientDiv.style.display = 'block';
    searchResults.style.display = 'none';
    patientSearchInput.value = patient.name;
}

// Hide search results when clicking outside
document.addEventListener('click', function(e) {
    const searchResults = document.getElementById('search-results');
    const patientSearchInput = document.getElementById('patient_search');
    
    if (!searchResults.contains(e.target) && e.target !== patientSearchInput) {
        searchResults.style.display = 'none';
    }
});
</script>
@endpush