@extends('layouts.app')

@section('title', 'Analyze Resume')

@section('content')
<div class="row justify-content-center text-center mb-5">
    <div class="col-lg-9">
        <h1 class="display-5 fw-bold mb-3">
            Unlock your <span class="text-gradient">Career Potential</span>
        </h1>
        <p class="lead text-secondary">
           Upload your resume. We'll map your skills, identify gaps, and suggest the perfect career path.
        </p>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- Upload Zone -->
        <div class="glass-panel p-4 mb-5">
            @if ($errors->any())
                <div class="alert alert-danger border-0 rounded-3 mb-4">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('resume.upload') }}" method="POST" enctype="multipart/form-data" id="resumeForm">
                @csrf
                
                <div class="upload-zone" id="dropZone">
                    <input type="file" class="d-none" id="resume" name="resume" accept=".pdf,.doc,.docx" required>
                    
                    <div class="upload-content text-center py-5">
                        <div class="upload-icon mb-4">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Drag & drop your resume here</h4>
                        <p class="text-secondary small mb-4">PDF, DOC, DOCX (Max 5MB)</p>
                        
                        <!-- The Button -->
                        <button type="button" class="btn btn-glow" id="browseBtn">
                            <i class="fa-solid fa-folder-open"></i> Browse Files
                        </button>

                        <div class="mt-4 d-none" id="filePreview">
                            <span class="badge bg-success-soft px-3 py-2 rounded-pill">
                                <i class="fa-solid fa-check-circle me-1"></i> <span id="fileNameDisplay"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-glow btn-lg px-5" id="submitBtn" disabled>
                        <i class="fa-solid fa-wand-magic-sparkles"></i> Start Analysis
                    </button>
                </div>
            </form>
        </div>

        <!-- Feature Cards -->
        <div class="row g-4">
            <div class="col-md-4">
                <div class="glass-panel h-100 text-center feature-card-hover">
                    <div class="feature-icon icon-purple mx-auto mb-3">
                        <i class="fa-solid fa-compass"></i>
                    </div>
                    <h5 class="fw-bold">Career Direction</h5>
                    <p class="text-secondary small mb-0">Discover roles that match your natural strengths.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass-panel h-100 text-center feature-card-hover">
                    <div class="feature-icon icon-blue mx-auto mb-3">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h5 class="fw-bold">Skill Mapping</h5>
                    <p class="text-secondary small mb-0">Visualize your current tech stack vs market needs.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass-panel h-100 text-center feature-card-hover">
                    <div class="feature-icon icon-teal mx-auto mb-3">
                        <i class="fa-solid fa-lightbulb"></i>
                    </div>
                    <h5 class="fw-bold">Next Moves</h5>
                    <p class="text-secondary small mb-0">Actionable steps to bridge your skill gaps.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .upload-zone {
        border: 2px dashed var(--border-glass);
        border-radius: 16px;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        background: rgba(255,255,255,0.02);
    }

    .upload-zone:hover, .upload-zone.active {
        border-color: var(--accent-main);
        background: rgba(99, 102, 241, 0.05);
        box-shadow: 0 0 30px rgba(99, 102, 241, 0.1);
    }

    .upload-icon {
        width: 70px;
        height: 70px;
        background: var(--accent-gradient);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        margin: 0 auto;
        box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
    }

    .feature-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .icon-purple { background: rgba(168, 85, 247, 0.15); color: #a855f7; }
    .icon-blue { background: rgba(99, 102, 241, 0.15); color: #6366f1; }
    .icon-teal { background: rgba(20, 184, 166, 0.15); color: #14b8a6; }

    .feature-card-hover:hover {
        transform: translateY(-5px);
        border-color: var(--border-glow);
    }

    .bg-success-soft { background: rgba(16, 185, 129, 0.15); color: #10b981; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('resume');
    const filePreview = document.getElementById('filePreview');
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    const submitBtn = document.getElementById('submitBtn');
    const browseBtn = document.getElementById('browseBtn');
    const form = document.getElementById('resumeForm');

    // 1. Handle Browse Button Click
    // We use stopPropagation so the click doesn't trigger the DropZone click event below
    if (browseBtn) {
        browseBtn.addEventListener('click', (e) => {
            e.stopPropagation(); // FIX: Prevents double triggering
            fileInput.click();
        });
    }
    
    // 2. Handle Drop Zone Click (clicking anywhere else in the box)
    dropZone.addEventListener('click', () => {
        fileInput.click();
    });

    // Drag & Drop Handlers
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('active');
    });

    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('active'));

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('active');
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            handleFile(e.dataTransfer.files[0]);
        }
    });

    fileInput.addEventListener('change', () => {
        if (fileInput.files.length) handleFile(fileInput.files[0]);
    });

    function handleFile(file) {
        const allowed = ["application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"];
        if (!allowed.includes(file.type)) {
            alert('Invalid file type. Please upload PDF or DOCX.');
            return;
        }
        if (file.size > 5000000) {
            alert('File too large. Max 5MB.');
            return;
        }
        
        fileNameDisplay.textContent = file.name;
        filePreview.classList.remove('d-none');
        submitBtn.disabled = false;
    }

    form.addEventListener('submit', function () {
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Analyzing...';
        submitBtn.disabled = true;
    });
});
</script>
@endpush