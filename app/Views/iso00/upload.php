<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4 px-3 px-lg-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="font-family: 'Poppins', 'Segoe UI', sans-serif; letter-spacing: 0.5px; font-size: 1.75rem;">
                Upload Dokumen ISO
            </h1>
            <p class="text-muted mb-0 d-flex align-items-center" style="font-family: 'Inter', sans-serif; font-size: 0.875rem;">
                <i data-feather="upload-cloud" width="14" height="14" class="me-2 opacity-75"></i>
                Unggah dokumen baru ke sistem ISO
            </p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="<?= base_url('iso_00/list_dokumen') ?>" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1 py-2 px-3 rounded-2">
                <i data-feather="arrow-left" width="14" height="14"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Progress Steps -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center position-relative">
                <!-- Progress Line -->
                <div class="position-absolute top-50 start-0 end-0" style="height: 2px; background: #e9ecef; z-index: 1;"></div>
                
                <!-- Steps -->
                <?php
                $steps = [
                    ['icon' => 'file-text', 'label' => 'Info Dokumen', 'active' => true],
                    ['icon' => 'upload', 'label' => 'Upload File', 'active' => false],
                    ['icon' => 'settings', 'label' => 'Konfigurasi', 'active' => false],
                    ['icon' => 'check-circle', 'label' => 'Review', 'active' => false]
                ];
                ?>
                
                <?php foreach($steps as $index => $step): ?>
                <div class="d-flex flex-column align-items-center position-relative" style="z-index: 2;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-2 
                         <?= $step['active'] ? 'bg-primary text-white' : 'bg-light text-muted' ?>"
                         style="width: 48px; height: 48px; font-size: 0.9rem; font-weight: 500; border: 3px solid white;">
                        <i data-feather="<?= $step['icon'] ?>" width="18" height="18"></i>
                    </div>
                    <span class="text-center" style="font-family: 'Inter', sans-serif; font-size: 0.75rem; font-weight: 500;">
                        <?= $step['label'] ?>
                    </span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center shadow-sm mb-4" 
         role="alert"
         style="border-radius: 10px; border-left: 4px solid #e63946; font-family: 'Inter', sans-serif;">
        <i data-feather="alert-circle" class="me-2" width="18" height="18"></i>
        <div class="flex-grow-1" style="font-size: 0.875rem;">
            <?= session()->getFlashdata('error') ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- Success Alert (if any) -->
    <?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm mb-4" 
         role="alert"
         style="border-radius: 10px; border-left: 4px solid #38b000; font-family: 'Inter', sans-serif;">
        <i data-feather="check-circle" class="me-2" width="18" height="18"></i>
        <div class="flex-grow-1" style="font-size: 0.875rem;">
            <?= session()->getFlashdata('success') ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="row">
        <!-- Upload Form -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; transition: all 0.3s ease;">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title fw-semibold d-flex align-items-center" 
                        style="font-family: 'Inter', sans-serif; font-size: 1rem;">
                        <i data-feather="file-plus" width="16" height="16" class="me-2 text-primary"></i>
                        Form Upload Dokumen
                    </h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('iso_00/save') ?>" method="post" enctype="multipart/form-data" id="uploadForm">
                        
                        <!-- Kode Dokumen -->
                        <div class="mb-4">
                            <label class="form-label fw-medium d-flex align-items-center mb-2" 
                                   style="font-family: 'Inter', sans-serif; font-size: 0.875rem;">
                                <i data-feather="hash" width="14" height="14" class="me-2 text-primary"></i>
                                Kode Dokumen
                                <span class="text-danger ms-1">*</span>
                            </label>
                            <input type="text" name="kode_dokumen" class="form-control form-control-lg rounded-2" 
                                   placeholder="Contoh: ISO-00-001-2024" required
                                   style="font-family: 'Inter', sans-serif; font-size: 0.9rem; padding: 0.75rem 1rem;">
                            <small class="text-muted mt-1 d-flex align-items-center" style="font-size: 0.75rem;">
                                <i data-feather="info" width="10" height="10" class="me-1"></i>
                                Gunakan format standar: ISO-[jenis]-[nomor]-[tahun]
                            </small>
                        </div>

                        <div class="row g-3">
                            <!-- Tanggal Dokumen -->
                            <div class="col-md-6">
                                <label class="form-label fw-medium d-flex align-items-center mb-2" 
                                       style="font-family: 'Inter', sans-serif; font-size: 0.875rem;">
                                    <i data-feather="calendar" width="14" height="14" class="me-2 text-primary"></i>
                                    Tanggal Dokumen
                                    <span class="text-danger ms-1">*</span>
                                </label>
                                <input type="date" name="tanggal" class="form-control form-control-lg rounded-2" required
                                       style="font-family: 'Inter', sans-serif; font-size: 0.9rem; padding: 0.75rem 1rem;">
                            </div>

                            <!-- Departement -->
                            <div class="col-md-6">
                                <label class="form-label fw-medium d-flex align-items-center mb-2" 
                                       style="font-family: 'Inter', sans-serif; font-size: 0.875rem;">
                                    <i data-feather="briefcase" width="14" height="14" class="me-2 text-primary"></i>
                                    Departemen
                                    <span class="text-danger ms-1">*</span>
                                </label>
                                <select name="departement" class="form-select form-select-lg rounded-2" required
                                        style="font-family: 'Inter', sans-serif; font-size: 0.9rem; padding: 0.75rem 1rem;">
                                    <option value="">Pilih Departemen</option>
                                    <option value="HRD">HRD</option>
                                    <option value="IT">IT</option>
                                    <option value="Production">Production</option>
                                    <option value="Quality Control">Quality Control</option>
                                    <option value="Finance">Finance</option>
                                    <option value="Marketing">Marketing</option>
                                    <option value="Maintenance">Maintenance</option>
                                    <option value="Logistics">Logistics</option>
                                </select>
                            </div>
                        </div>

                        <!-- Nama File -->
                        <div class="mb-4 mt-4">
                            <label class="form-label fw-medium d-flex align-items-center mb-2" 
                                   style="font-family: 'Inter', sans-serif; font-size: 0.875rem;">
                                <i data-feather="file-text" width="14" height="14" class="me-2 text-primary"></i>
                                Nama File
                                <span class="text-danger ms-1">*</span>
                            </label>
                            <input type="text" name="nama_file" class="form-control form-control-lg rounded-2" 
                                   placeholder="Contoh: SOP_Penggunaan_Mesin_Produksi" required
                                   style="font-family: 'Inter', sans-serif; font-size: 0.9rem; padding: 0.75rem 1rem;">
                            <small class="text-muted mt-1 d-flex align-items-center" style="font-size: 0.75rem;">
                                <i data-feather="info" width="10" height="10" class="me-1"></i>
                                Gunakan nama yang deskriptif dan mudah dipahami
                            </small>
                        </div>

                        <!-- Upload Dokumen -->
                        <div class="mb-4">
                            <label class="form-label fw-medium d-flex align-items-center mb-2" 
                                   style="font-family: 'Inter', sans-serif; font-size: 0.875rem;">
                                <i data-feather="upload" width="14" height="14" class="me-2 text-primary"></i>
                                Upload Dokumen (PDF)
                                <span class="text-danger ms-1">*</span>
                            </label>
                            
                            <!-- File Upload Area -->
                            <div class="border-2 border-dashed rounded-3 p-5 text-center position-relative" 
                                 style="border-color: #dee2e6; background-color: #f8f9fa; cursor: pointer;"
                                 id="fileDropArea">
                                <input type="file" name="upload_dokumen" id="fileInput" 
                                       accept="application/pdf" class="d-none" required>
                                
                                <div id="fileUploadContent">
                                    <i data-feather="upload-cloud" width="48" height="48" class="text-muted mb-3"></i>
                                    <h6 class="mb-2" style="font-family: 'Inter', sans-serif; font-size: 0.95rem;">
                                        Drag & drop file PDF di sini
                                    </h6>
                                    <p class="text-muted mb-3" style="font-size: 0.8rem;">
                                        atau klik untuk memilih file
                                    </p>
                                    <div class="badge bg-light text-dark px-3 py-2 rounded-pill">
                                        <i data-feather="file" width="12" height="12" class="me-1"></i>
                                        Hanya file PDF (max. 10MB)
                                    </div>
                                </div>
                                
                                <!-- File Preview (hidden by default) -->
                                <div id="filePreview" class="d-none">
                                    <div class="d-flex align-items-center justify-content-between bg-white p-3 rounded-2 shadow-sm">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-danger bg-opacity-10 rounded-circle p-2 me-3">
                                                <i data-feather="file-text" width="20" height="20" class="text-danger"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0" id="fileName" style="font-size: 0.9rem;"></h6>
                                                <small class="text-muted" id="fileSize" style="font-size: 0.75rem;"></small>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFile()">
                                            <i data-feather="trash-2" width="12" height="12"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Upload Progress (hidden by default) -->
                            <div class="mt-3 d-none" id="uploadProgress">
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="text-muted" style="font-size: 0.75rem;">Upload progress</small>
                                    <small class="text-muted" id="progressPercent" style="font-size: 0.75rem;">0%</small>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar" id="progressBar" role="progressbar" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-4">
                            <label class="form-label fw-medium d-flex align-items-center mb-2" 
                                   style="font-family: 'Inter', sans-serif; font-size: 0.875rem;">
                                <i data-feather="message-square" width="14" height="14" class="me-2 text-primary"></i>
                                Keterangan
                            </label>
                            <textarea name="keterangan" class="form-control form-control-lg rounded-2" rows="4"
                                      placeholder="Deskripsi singkat tentang dokumen ini..."
                                      style="font-family: 'Inter', sans-serif; font-size: 0.9rem; padding: 0.75rem 1rem; resize: vertical;"></textarea>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label class="form-label fw-medium d-flex align-items-center mb-2" 
                                   style="font-family: 'Inter', sans-serif; font-size: 0.875rem;">
                                <i data-feather="activity" width="14" height="14" class="me-2 text-primary"></i>
                                Status Dokumen
                                <span class="text-danger ms-1">*</span>
                            </label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-check card border rounded-2 p-3 h-100" 
                                         style="border-color: #dee2e6 !important; cursor: pointer;"
                                         onclick="selectStatus('save')">
                                        <input class="form-check-input" type="radio" name="status" 
                                               id="statusSave" value="save" checked>
                                        <label class="form-check-label w-100" for="statusSave">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                                    <i data-feather="check-circle" width="18" height="18" class="text-success"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0" style="font-size: 0.9rem;">Save (Aktif/Layak)</h6>
                                                    <small class="text-muted" style="font-size: 0.75rem;">
                                                        Dokumen aktif dan dapat digunakan
                                                    </small>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check card border rounded-2 p-3 h-100" 
                                         style="border-color: #dee2e6 !important; cursor: pointer;"
                                         onclick="selectStatus('non-save')">
                                        <input class="form-check-input" type="radio" name="status" 
                                               id="statusNonSave" value="non-save">
                                        <label class="form-check-label w-100" for="statusNonSave">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="bg-danger bg-opacity-10 rounded-circle p-2 me-3">
                                                    <i data-feather="x-circle" width="18" height="18" class="text-danger"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0" style="font-size: 0.9rem;">Non-Save (Tidak Layak)</h6>
                                                    <small class="text-muted" style="font-size: 0.75rem;">
                                                        Dokumen tidak aktif atau perlu revisi
                                                    </small>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
                            <a href="<?= base_url('iso_00/list_dokumen') ?>" class="btn btn-outline-secondary d-flex align-items-center gap-2 py-2 px-4 rounded-2">
                                <i data-feather="x" width="16" height="16"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 py-2 px-5 rounded-2"
                                    id="submitBtn">
                                <i data-feather="iso_00/upload" width="16" height="16"></i>
                                Upload Dokumen
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Instructions Panel -->
        <div class="col-lg-4">
            <div class="sticky-top" style="top: 20px;">
                <!-- Requirements Card -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                    <div class="card-header bg-transparent border-0 pb-0">
                        <h5 class="card-title fw-semibold d-flex align-items-center" 
                            style="font-family: 'Inter', sans-serif; font-size: 1rem;">
                            <i data-feather="alert-circle" width="16" height="16" class="me-2 text-primary"></i>
                            Persyaratan Upload
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2 d-flex align-items-start">
                                <i data-feather="check" width="14" height="14" class="text-success me-2 mt-1"></i>
                                <span style="font-size: 0.85rem;">File harus dalam format PDF</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i data-feather="check" width="14" height="14" class="text-success me-2 mt-1"></i>
                                <span style="font-size: 0.85rem;">Maksimal ukuran file: 10MB</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i data-feather="check" width="14" height="14" class="text-success me-2 mt-1"></i>
                                <span style="font-size: 0.85rem;">Nama file tidak mengandung karakter spesial</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i data-feather="check" width="14" height="14" class="text-success me-2 mt-1"></i>
                                <span style="font-size: 0.85rem;">Pastikan dokumen sudah final sebelum upload</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i data-feather="check" width="14" height="14" class="text-success me-2 mt-1"></i>
                                <span style="font-size: 0.85rem;">Isi semua field yang wajib diisi (*)</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Recent Uploads -->
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-header bg-transparent border-0 pb-0">
                        <h5 class="card-title fw-semibold d-flex align-items-center" 
                            style="font-family: 'Inter', sans-serif; font-size: 1rem;">
                            <i data-feather="clock" width="16" height="16" class="me-2 text-primary"></i>
                            Upload Terbaru
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <?php
                            // Simulated recent uploads - in real app, you would fetch from database
                            $recentUploads = [
                                ['code' => 'ISO-00-125', 'name' => 'SOP Maintenance', 'time' => '2 jam lalu'],
                                ['code' => 'ISO-001-034', 'name' => 'Quality Report', 'time' => '5 jam lalu'],
                                ['code' => 'ISO-00-126', 'name' => 'Safety Manual', 'time' => '1 hari lalu'],
                            ];
                            ?>
                            
                            <?php foreach($recentUploads as $upload): ?>
                            <div class="list-group-item border-0 px-0 py-2">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 36px; height: 36px;">
                                        <i data-feather="file-text" width="14" height="14" class="text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0" style="font-size: 0.85rem;"><?= $upload['code'] ?></h6>
                                        <small class="text-muted d-block" style="font-size: 0.75rem;">
                                            <?= $upload['name'] ?>
                                        </small>
                                    </div>
                                    <small class="text-muted" style="font-size: 0.7rem;">
                                        <?= $upload['time'] ?>
                                    </small>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@400;500;600;700&display=swap');

/* Card hover effects */
.card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08) !important;
}

/* File drop area */
#fileDropArea {
    transition: all 0.3s ease;
    border-style: dashed !important;
}

#fileDropArea:hover {
    border-color: #4361ee !important;
    background-color: rgba(67, 97, 238, 0.02) !important;
}

#fileDropArea.dragover {
    border-color: #4361ee !important;
    background-color: rgba(67, 97, 238, 0.05) !important;
    transform: scale(1.01);
}

/* Form controls focus */
.form-control:focus, .form-select:focus {
    border-color: #4361ee;
    box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.15);
}

.form-control-lg {
    border: 1px solid #dee2e6;
}

/* Status card selection */
.form-check.card {
    transition: all 0.2s ease;
}

.form-check.card:hover {
    border-color: #4361ee !important;
    background-color: rgba(67, 97, 238, 0.02);
}

.form-check-input:checked + .form-check-label .card {
    border-color: #4361ee !important;
    background-color: rgba(67, 97, 238, 0.05);
}

/* Button hover effects */
.btn-primary:hover {
    background-color: #3a56d4;
    border-color: #3a56d4;
    transform: translateY(-1px);
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    color: white;
    border-color: #6c757d;
}

/* Progress bar animation */
.progress-bar {
    transition: width 0.3s ease;
}

/* List group item hover */
.list-group-item:hover {
    background-color: rgba(67, 97, 238, 0.02);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .container-fluid {
        padding-left: 1rem !important;
        padding-right: 1rem !important;
    }
    
    .d-flex.justify-content-between.align-items-center.mb-4 {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 1rem;
    }
    
    .row.mb-5 .col-12 .d-flex {
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .border-2.border-dashed.rounded-3.p-5 {
        padding: 2rem !important;
    }
    
    .d-flex.justify-content-between.align-items-center.mt-5 {
        flex-direction: column;
        gap: 1rem;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
}

/* Smooth transitions */
.btn, .card, #fileDropArea, .form-check.card {
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Color opacity utilities */
.bg-primary.bg-opacity-10 {
    background-color: rgba(67, 97, 238, 0.1) !important;
}

.bg-success.bg-opacity-10 {
    background-color: rgba(56, 176, 0, 0.1) !important;
}

.bg-danger.bg-opacity-10 {
    background-color: rgba(230, 57, 70, 0.1) !important;
}

/* Border dashed utility */
.border-dashed {
    border-style: dashed !important;
}

/* Sticky sidebar */
.sticky-top {
    position: -webkit-sticky;
    position: sticky;
}
</style>

<script>
// Disable right click
document.addEventListener("contextmenu", e => e.preventDefault());

// Feather icons initialization
if (typeof feather !== 'undefined') {
    feather.replace();
}

// File upload functionality
const fileDropArea = document.getElementById('fileDropArea');
const fileInput = document.getElementById('fileInput');
const fileUploadContent = document.getElementById('fileUploadContent');
const filePreview = document.getElementById('filePreview');
const fileName = document.getElementById('fileName');
const fileSize = document.getElementById('fileSize');
const uploadProgress = document.getElementById('uploadProgress');
const progressBar = document.getElementById('progressBar');
const progressPercent = document.getElementById('progressPercent');

// Click to select file
fileDropArea.addEventListener('click', () => fileInput.click());

// Drag and drop events
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    fileDropArea.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    fileDropArea.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    fileDropArea.addEventListener(eventName, unhighlight, false);
});

function highlight() {
    fileDropArea.classList.add('dragover');
}

function unhighlight() {
    fileDropArea.classList.remove('dragover');
}

// Handle dropped files
fileDropArea.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    handleFiles(files);
}

// Handle file selection
fileInput.addEventListener('change', function() {
    handleFiles(this.files);
});

function handleFiles(files) {
    if (files.length === 0) return;
    
    const file = files[0];
    
    // Validate file type
    if (file.type !== 'application/pdf') {
        showNotification('Hanya file PDF yang diperbolehkan', 'error');
        return;
    }
    
    // Validate file size (10MB)
    if (file.size > 10 * 1024 * 1024) {
        showNotification('Ukuran file maksimal 10MB', 'error');
        return;
    }
    
    // Show file preview
    fileName.textContent = file.name;
    fileSize.textContent = formatFileSize(file.size);
    
    fileUploadContent.classList.add('d-none');
    filePreview.classList.remove('d-none');
    
    // Simulate upload progress
    simulateUploadProgress();
}

function removeFile() {
    fileInput.value = '';
    fileUploadContent.classList.remove('d-none');
    filePreview.classList.add('d-none');
    uploadProgress.classList.add('d-none');
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function simulateUploadProgress() {
    uploadProgress.classList.remove('d-none');
    progressBar.style.width = '0%';
    progressPercent.textContent = '0%';
    
    let progress = 0;
    const interval = setInterval(() => {
        progress += Math.random() * 10;
        if (progress >= 100) {
            progress = 100;
            clearInterval(interval);
        }
        
        progressBar.style.width = progress + '%';
        progressPercent.textContent = Math.round(progress) + '%';
        
        // Change color based on progress
        if (progress < 30) {
            progressBar.className = 'progress-bar bg-warning';
        } else if (progress < 70) {
            progressBar.className = 'progress-bar bg-info';
        } else {
            progressBar.className = 'progress-bar bg-success';
        }
    }, 100);
}

// Status selection
function selectStatus(status) {
    if (status === 'save') {
        document.getElementById('statusSave').checked = true;
    } else {
        document.getElementById('statusNonSave').checked = true;
    }
    
    // Visual feedback
    document.querySelectorAll('.form-check.card').forEach(card => {
        card.style.borderColor = '#dee2e6';
        card.style.backgroundColor = '';
    });
    
    const selectedCard = document.querySelector(`input[value="${status}"]`).closest('.form-check.card');
    selectedCard.style.borderColor = '#4361ee';
    selectedCard.style.backgroundColor = 'rgba(67, 97, 238, 0.05)';
}

// Form validation
document.getElementById('uploadForm').addEventListener('submit', function(e) {
    const kodeDokumen = document.querySelector('input[name="kode_dokumen"]').value.trim();
    const fileInput = document.querySelector('input[name="upload_dokumen"]');
    
    // Validate kode dokumen format
    if (!kodeDokumen.match(/^ISO-[A-Z0-9]+-[A-Z0-9]+-\d{4}$/i)) {
        e.preventDefault();
        showNotification('Format kode dokumen tidak valid. Gunakan format: ISO-00-001-2024', 'error');
        return;
    }
    
    // Validate file
    if (!fileInput.files.length) {
        e.preventDefault();
        showNotification('Pilih file PDF terlebih dahulu', 'error');
        return;
    }
    
    // Show loading on submit button
    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = `
        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
        Mengupload...
    `;
    submitBtn.disabled = true;
    
    // Restore button after 5 seconds (in case submission fails)
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 5000);
});

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'error' ? 'danger' : type === 'success' ? 'success' : 'info'} 
                           alert-dismissible fade show position-fixed`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        font-family: 'Inter', sans-serif;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        font-size: 0.875rem;
    `;
    
    const icon = type === 'error' ? 'alert-circle' : type === 'success' ? 'check-circle' : 'info';
    
    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <i data-feather="${icon}" class="me-2" width="18" height="18"></i>
            <span>${message}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Initialize today's date
document.addEventListener('DOMContentLoaded', function() {
    // Set today's date as default
    const today = new Date().toISOString().split('T')[0];
    document.querySelector('input[name="tanggal"]').value = today;
    
    // Initialize status cards
    selectStatus('save');
});
</script>

<?= $this->endSection() ?>