<!-- resources/views/treatments/create.blade.php -->
@extends('layouts.app')

@section('title', 'Tambah Tindakan Baru')

@section('content')
<!-- PAGE HEADER -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-plus-circle me-2 text-primary"></i>
        Tambah Tindakan Medis Baru
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('treatments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<!-- FORM CARD -->
<div class="row">
    <div class="col-lg-8 mx-auto">
        <form action="{{ route('treatments.store') }}" method="POST">
            @csrf
            
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
                                   value="{{ old('code') }}" 
                                   required
                                   placeholder="Contoh: T001"
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
                                   value="{{ old('name') }}" 
                                   required
                                   placeholder="Contoh: Scaling Gigi">
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
                                       value="{{ old('price') }}" 
                                       required
                                       min="0"
                                       step="1000"
                                       placeholder="0">
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
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        <span id="status-label">Aktif</span>
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
                                      rows="4"
                                      placeholder="Jelaskan detail tindakan medis ini...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Opsional - Deskripsi akan membantu dalam pemilihan tindakan</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PREVIEW CARD -->
            <div class="card shadow mb-4 border-info">
                <div class="card-header bg-info text-white py-3">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-eye me-2"></i>Preview Tindakan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <small class="text-muted d-block">Kode</small>
                            <strong id="preview-code">-</strong>
                        </div>
                        <div class="col-md-5">
                            <small class="text-muted d-block">Nama Tindakan</small>
                            <strong id="preview-name">-</strong>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Harga</small>
                            <strong class="text-success" id="preview-price">Rp 0</strong>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <small class="text-muted d-block">Deskripsi</small>
                            <p id="preview-description" class="mb-0">-</p>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <span class="badge bg-success" id="preview-status">Aktif</span>
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
                            <i class="fas fa-save me-2"></i>Simpan Tindakan
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
    // Elements
    const codeInput = document.getElementById('code');
    const nameInput = document.getElementById('name');
    const priceInput = document.getElementById('price');
    const descriptionInput = document.getElementById('description');
    const statusCheckbox = document.getElementById('is_active');
    const statusLabel = document.getElementById('status-label');
    
    // Preview elements
    const previewCode = document.getElementById('preview-code');
    const previewName = document.getElementById('preview-name');
    const previewPrice = document.getElementById('preview-price');
    const previewDescription = document.getElementById('preview-description');
    const previewStatus = document.getElementById('preview-status');
    const priceDisplay = document.getElementById('price-display');

    // Auto-uppercase code
    codeInput.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
        updatePreview();
    });

    // Update preview on input
    nameInput.addEventListener('input', updatePreview);
    priceInput.addEventListener('input', function() {
        updatePreview();
        updatePriceDisplay();
    });
    descriptionInput.addEventListener('input', updatePreview);
    statusCheckbox.addEventListener('change', function() {
        updateStatusLabel();
        updatePreview();
    });

    function updatePreview() {
        previewCode.textContent = codeInput.value || '-';
        previewName.textContent = nameInput.value || '-';
        
        const price = parseInt(priceInput.value) || 0;
        previewPrice.textContent = 'Rp ' + formatNumber(price);
        
        previewDescription.textContent = descriptionInput.value || '-';
        
        if (statusCheckbox.checked) {
            previewStatus.className = 'badge bg-success';
            previewStatus.innerHTML = '<i class="fas fa-check me-1"></i>Aktif';
        } else {
            previewStatus.className = 'badge bg-secondary';
            previewStatus.innerHTML = '<i class="fas fa-times me-1"></i>Tidak Aktif';
        }
    }

    function updatePriceDisplay() {
        const price = parseInt(priceInput.value) || 0;
        priceDisplay.textContent = 'Terbilang: ' + terbilang(price) + ' rupiah';
    }

    function updateStatusLabel() {
        statusLabel.textContent = statusCheckbox.checked ? 'Aktif' : 'Tidak Aktif';
        statusLabel.className = statusCheckbox.checked ? 'text-success' : 'text-secondary';
    }

    function formatNumber(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    function terbilang(angka) {
        const bilangan = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
        
        if (angka < 12) return bilangan[angka];
        if (angka < 20) return terbilang(angka - 10) + ' Belas';
        if (angka < 100) return terbilang(Math.floor(angka / 10)) + ' Puluh ' + terbilang(angka % 10);
        if (angka < 200) return 'Seratus ' + terbilang(angka - 100);
        if (angka < 1000) return terbilang(Math.floor(angka / 100)) + ' Ratus ' + terbilang(angka % 100);
        if (angka < 2000) return 'Seribu ' + terbilang(angka - 1000);
        if (angka < 1000000) return terbilang(Math.floor(angka / 1000)) + ' Ribu ' + terbilang(angka % 1000);
        if (angka < 1000000000) return terbilang(Math.floor(angka / 1000000)) + ' Juta ' + terbilang(angka % 1000000);
        
        return formatNumber(angka);
    }

    // Initialize
    updatePreview();
    updatePriceDisplay();
    updateStatusLabel();
});
</script>
@endpush