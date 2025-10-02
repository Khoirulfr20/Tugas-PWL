<!-- resources/views/treatments/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Edit Tindakan - ' . $treatment->name)

@section('content')
<!-- PAGE HEADER -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-edit me-2 text-primary"></i>
        Edit Tindakan Medis
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('treatments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<!-- INFO BANNER -->
<div class="row mb-4">
    <div class="col-lg-8 mx-auto">
        <div class="alert alert-info">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle fa-2x me-3"></i>
                <div>
                    <strong>Edit Tindakan:</strong> {{ $treatment->name }}
                    <br>
                    <small>Kode: <span class="badge bg-dark">{{ $treatment->code }}</span></small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FORM CARD -->
<div class="row">
    <div class="col-lg-8 mx-auto">
        <form action="{{ route('treatments.update', $treatment) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- INFORMASI TINDAKAN -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>Informasi Tindakan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Kode Tindakan -->
                        <div class="col-md-4 mb-3">
                            <label for="code" class="form-label">
                                Kode Tindakan <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('code') is-invalid @enderror" 
                                   id="code" 
                                   name="code" 
                                   value="{{ old('code', $treatment->code) }}" 
                                   required
                                   style="text-transform: uppercase;">
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Kode harus unik
                            </small>
                        </div>

                        <!-- Nama Tindakan -->
                        <div class="col-md-8 mb-3">
                            <label for="name" class="form-label">
                                Nama Tindakan <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $treatment->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Harga -->
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">
                                Harga <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       id="price" 
                                       name="price" 
                                       value="{{ old('price', $treatment->price) }}" 
                                       required
                                       min="0"
                                       step="1000">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted" id="price-display"></small>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Status <span class="text-danger">*</span>
                            </label>
                            <div class="d-flex gap-3 align-items-center h-100">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="is_active" 
                                           name="is_active" 
                                           value="1"
                                           {{ old('is_active', $treatment->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        <span id="status-label">{{ $treatment->is_active ? 'Aktif' : 'Tidak Aktif' }}</span>
                                    </label>
                                </div>
                            </div>
                            <small class="text-muted">
                                Tindakan yang tidak aktif tidak akan muncul di pilihan form rekam medis
                            </small>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">
                                Deskripsi Tindakan
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4">{{ old('description', $treatment->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Opsional</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- USAGE STATISTICS -->
            <div class="card shadow mb-4 border-info">
                <div class="card-header bg-light py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-chart-bar me-2"></i>Statistik Penggunaan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <small class="text-muted d-block">Total Digunakan</small>
                            <h4 class="mb-0 text-primary">{{ $treatment->treatmentRecords->count() }}</h4>
                            <small class="text-muted">kali</small>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Terakhir Digunakan</small>
                            <h6 class="mb-0">
                                {{ $treatment->treatmentRecords()->latest()->first()?->created_at?->format('d M Y') ?? 'Belum pernah' }}
                            </h6>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Total Pendapatan</small>
                            <h6 class="mb-0 text-success">
                                Rp {{ number_format($treatment->treatmentRecords->sum(function($record) { return $record->price * $record->quantity; }), 0, ',', '.') }}
                            </h6>
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
                            <strong>{{ $treatment->created_at->format('d F Y, H:i') }}</strong>
                            <br>
                            <small class="text-muted">{{ $treatment->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Terakhir Diubah:</small>
                            <strong>{{ $treatment->updated_at->format('d F Y, H:i') }}</strong>
                            <br>
                            <small class="text-muted">{{ $treatment->updated_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FORM ACTIONS -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('treatments.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Update Tindakan
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- DANGER ZONE -->
        @if($treatment->treatmentRecords->count() === 0)
        <div class="card shadow mb-4 border-danger">
            <div class="card-header bg-danger text-white py-3">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-exclamation-triangle me-2"></i>Danger Zone
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Hapus Tindakan</strong>
                        <p class="text-muted mb-0">
                            Tindakan ini belum pernah digunakan. 
                            <strong>Tindakan ini dapat dihapus dengan aman.</strong>
                        </p>
                    </div>
                    <form action="{{ route('treatments.destroy', $treatment) }}" 
                          method="POST" 
                          onsubmit="return confirm('Yakin ingin menghapus tindakan {{ $treatment->name }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt me-2"></i>Hapus Tindakan
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Perhatian:</strong> Tindakan ini sudah digunakan dalam {{ $treatment->treatmentRecords->count() }} rekam medis dan tidak dapat dihapus.
            Anda dapat menonaktifkan tindakan ini jika tidak ingin digunakan lagi.
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const priceInput = document.getElementById('price');
    const priceDisplay = document.getElementById('price-display');
    const statusCheckbox = document.getElementById('is_active');
    const statusLabel = document.getElementById('status-label');

    function updatePriceDisplay() {
        const price = parseInt(priceInput.value) || 0;
        priceDisplay.textContent = 'Rp ' + formatNumber(price);
    }

    function updateStatusLabel() {
        statusLabel.textContent = statusCheckbox.checked ? 'Aktif' : 'Tidak Aktif';
        statusLabel.className = statusCheckbox.checked ? 'text-success' : 'text-secondary';
    }

    function formatNumber(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    priceInput.addEventListener('input', updatePriceDisplay);
    statusCheckbox.addEventListener('change', updateStatusLabel);

    // Auto-uppercase code
    document.getElementById('code').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });

    // Initialize
    updatePriceDisplay();
});
</script>
@endpush