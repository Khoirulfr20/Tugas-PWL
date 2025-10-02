<!-- resources/views/medical-records/show.blade.php -->
@extends('layouts.app')

@section('title', 'Detail Rekam Medis')

@section('content')
<!-- PAGE HEADER -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-file-medical me-2 text-primary"></i>
        Detail Rekam Medis
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('medical-records.edit', $medicalRecord) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <button type="button" class="btn btn-success" onclick="window.print()">
                <i class="fas fa-print me-1"></i>Print
            </button>
            <button type="button" class="btn btn-info" onclick="downloadPDF()">
                <i class="fas fa-file-pdf me-1"></i>PDF
            </button>
        </div>
        <a href="{{ route('medical-records.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <!-- LEFT SIDEBAR - PATIENT INFO -->
    <div class="col-md-4">
        <!-- PATIENT CARD -->
        <div class="card shadow mb-4">
            <div class="card-body text-center">
                <div class="avatar-large mx-auto mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; font-weight: bold;">
                    {{ strtoupper(substr($medicalRecord->patient->name, 0, 2)) }}
                </div>
                <h4 class="mb-1">{{ $medicalRecord->patient->name }}</h4>
                <p class="text-muted mb-3">
                    <span class="badge bg-secondary">{{ $medicalRecord->patient->patient_number }}</span>
                </p>
                <div class="text-start">
                    <small class="text-muted d-block">Umur</small>
                    <strong>{{ $medicalRecord->patient->age }} tahun</strong>
                    <hr>
                    <small class="text-muted d-block">Jenis Kelamin</small>
                    <strong>
                        <i class="fas fa-{{ $medicalRecord->patient->gender === 'L' ? 'mars text-primary' : 'venus text-danger' }} me-1"></i>
                        {{ $medicalRecord->patient->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </strong>
                    <hr>
                    <small class="text-muted d-block">Telepon</small>
                    <strong>{{ $medicalRecord->patient->phone }}</strong>
                </div>
                <hr>
                <a href="{{ route('patients.show', $medicalRecord->patient) }}" class="btn btn-outline-primary btn-sm w-100">
                    <i class="fas fa-user me-1"></i>Lihat Profil Lengkap
                </a>
            </div>
        </div>

        <!-- EXAMINATION INFO -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i>Informasi Pemeriksaan
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block">Tanggal Pemeriksaan</small>
                    <strong>{{ $medicalRecord->examination_date->format('d F Y') }}</strong>
                    <br>
                    <small class="text-muted">{{ $medicalRecord->examination_date->diffForHumans() }}</small>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">Dokter/Petugas</small>
                    <strong>
                        <i class="fas fa-user-md me-1 text-primary"></i>
                        {{ $medicalRecord->user->name }}
                    </strong>
                </div>
                <div class="mb-0">
                    <small class="text-muted d-block">Dibuat Pada</small>
                    <strong>{{ $medicalRecord->created_at->format('d F Y, H:i') }}</strong>
                </div>
            </div>
        </div>

        <!-- TOTAL COST CARD -->
        @if($medicalRecord->treatments->count() > 0)
        <div class="card shadow mb-4 border-success">
            <div class="card-header bg-success text-white">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-money-bill-wave me-2"></i>Total Biaya
                </h6>
            </div>
            <div class="card-body text-center">
                <h3 class="text-success mb-0">Rp {{ number_format($medicalRecord->total_cost, 0, ',', '.') }}</h3>
                <small class="text-muted">{{ $medicalRecord->treatments->count() }} tindakan</small>
            </div>
        </div>
        @endif
    </div>

    <!-- RIGHT CONTENT -->
    <div class="col-md-8">
        <!-- CHIEF COMPLAINT -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-comment-medical me-2"></i>Keluhan Utama (Chief Complaint)
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $medicalRecord->chief_complaint }}</p>
            </div>
        </div>

        <!-- HISTORY PRESENT ILLNESS -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-history me-2"></i>Riwayat Penyakit Sekarang
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $medicalRecord->history_present_illness }}</p>
            </div>
        </div>

        <!-- CLINICAL EXAMINATION -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-stethoscope me-2"></i>Pemeriksaan Klinis
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $medicalRecord->clinical_examination }}</p>
            </div>
        </div>

        <!-- DIAGNOSIS -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-diagnoses me-2"></i>Diagnosis
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $medicalRecord->diagnosis }}</p>
            </div>
        </div>

        <!-- TREATMENT PLAN -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-tasks me-2"></i>Rencana Perawatan
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $medicalRecord->treatment_plan }}</p>
            </div>
        </div>

        <!-- TREATMENT PERFORMED -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-procedures me-2"></i>Tindakan Yang Dilakukan
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $medicalRecord->treatment_performed }}</p>
            </div>
        </div>

        <!-- TREATMENTS LIST -->
        @if($medicalRecord->treatments->count() > 0)
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list me-2"></i>Daftar Tindakan Medis
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Tindakan</th>
                                <th width="15%">Gigi</th>
                                <th width="10%">Qty</th>
                                <th width="20%">Harga</th>
                                <th width="20%">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($medicalRecord->treatments as $treatment)
                            <tr>
                                <td>
                                    <strong>{{ $treatment->treatment->name }}</strong>
                                    @if($treatment->notes)
                                        <br>
                                        <small class="text-muted">{{ $treatment->notes }}</small>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{ $treatment->tooth_number ?? '-' }}
                                </td>
                                <td class="text-center">{{ $treatment->quantity }}</td>
                                <td class="text-end">Rp {{ number_format($treatment->price, 0, ',', '.') }}</td>
                                <td class="text-end">
                                    <strong>Rp {{ number_format($treatment->total_price, 0, ',', '.') }}</strong>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-success">
                                <td colspan="4" class="text-end"><strong>TOTAL:</strong></td>
                                <td class="text-end">
                                    <strong class="text-success">Rp {{ number_format($medicalRecord->total_cost, 0, ',', '.') }}</strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- PRESCRIPTION -->
        @if($medicalRecord->prescription)
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-prescription me-2"></i>Resep Obat
                </h6>
            </div>
            <div class="card-body">
                <div class="alert alert-warning mb-0">
                    <i class="fas fa-pills me-2"></i>
                    <pre class="mb-0" style="white-space: pre-wrap; font-family: inherit;">{{ $medicalRecord->prescription }}</pre>
                </div>
            </div>
        </div>
        @endif

        <!-- NOTES -->
        @if($medicalRecord->notes)
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-sticky-note me-2"></i>Catatan Tambahan
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $medicalRecord->notes }}</p>
            </div>
        </div>
        @endif

        <!-- IMAGES -->
        @if($medicalRecord->images->count() > 0)
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-images me-2"></i>Gambar Klinis ({{ $medicalRecord->images->count() }})
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach($medicalRecord->images as $image)
                    <div class="col-md-4">
                        <div class="card">
                            <img src="{{ Storage::url($image->image_path) }}" 
                                 class="card-img-top" 
                                 alt="{{ $image->image_type }}"
                                 style="height: 200px; object-fit: cover; cursor: pointer;"
                                 onclick="viewImage('{{ Storage::url($image->image_path) }}', '{{ $image->image_type }}')">
                            <div class="card-body">
                                <span class="badge bg-info">{{ ucfirst($image->image_type) }}</span>
                                @if($image->description)
                                    <p class="mb-0 mt-2"><small>{{ $image->description }}</small></p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- CHANGE LOG -->
        <div class="card shadow mb-4 border-secondary">
            <div class="card-header bg-light">
                <h6 class="m-0 font-weight-bold text-secondary">
                    <i class="fas fa-history me-2"></i>Riwayat Perubahan
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted d-block">Dibuat Pada:</small>
                        <strong>{{ $medicalRecord->created_at->format('d F Y, H:i') }}</strong>
                        <br>
                        <small class="text-muted">{{ $medicalRecord->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Terakhir Diubah:</small>
                        <strong>{{ $medicalRecord->updated_at->format('d F Y, H:i') }}</strong>
                        <br>
                        <small class="text-muted">{{ $medicalRecord->updated_at->diffForHumans() }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- IMAGE MODAL -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Gambar Klinis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img src="" id="modalImage" class="img-fluid" alt="Clinical Image">
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @media print {
        .btn-toolbar, .btn-group, .btn, nav {
            display: none !important;
        }
        .card {
            border: 1px solid #dee2e6 !important;
            box-shadow: none !important;
            page-break-inside: avoid;
        }
        .col-md-4 {
            display: none;
        }
        .col-md-8 {
            width: 100% !important;
            max-width: 100% !important;
        }
    }
    
    .card img:hover {
        opacity: 0.8;
        transition: opacity 0.3s ease;
    }
</style>
@endpush

@push('scripts')
<script>
function viewImage(imageSrc, imageType) {
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModalLabel').textContent = 'Gambar Klinis - ' + imageType;
    modal.show();
}

function downloadPDF() {
    // Open print dialog for PDF save
    window.print();
}

// Keyboard shortcut: P for print
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.key === 'p') {
        e.preventDefault();
        window.print();
    }
});
</script>
@endpush