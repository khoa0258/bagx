@extends('admin.layouts.app')

@section('title', 'Thêm sản phẩm')
@section('page-title', 'Thêm sản phẩm mới')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên sản phẩm *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="5">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Thêm section upload hình ảnh -->
                    <div class="mb-4">
                        <label class="form-label">Hình ảnh sản phẩm</label>
                        <div class="upload-area border-2 border-dashed border-secondary rounded p-4 text-center" 
                             id="upload-area" style="min-height: 200px;">
                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-2">Kéo thả hình ảnh vào đây hoặc click để chọn</p>
                            <p class="text-muted small">Tối đa 5 hình ảnh, định dạng: JPG, PNG, GIF (Max: 2MB/hình)</p>
                            <input type="file" id="images" name="images[]" multiple accept="image/*" class="d-none">
                            <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('images').click()">
                                <i class="fas fa-plus"></i> Chọn hình ảnh
                            </button>
                        </div>
                        @error('images')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        @error('images.*')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        
                        <!-- Preview area -->
                        <div id="image-preview" class="row mt-3"></div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="id_category" class="form-label">Danh mục *</label>
                        <select class="form-select @error('id_category') is-invalid @enderror" 
                                id="id_category" name="id_category" required>
                            <option value="">Chọn danh mục</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('id_category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->mainCategory->name }} - {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="id_brand" class="form-label">Thương hiệu *</label>
                        <select class="form-select @error('id_brand') is-invalid @enderror" 
                                id="id_brand" name="id_brand" required>
                            <option value="">Chọn thương hiệu</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('id_brand') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_brand')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="id_discount" class="form-label">Khuyến mãi</label>
                        <select class="form-select" id="id_discount" name="id_discount">
                            <option value="">Không có</option>
                            @foreach($discounts as $discount)
                                <option value="{{ $discount->id }}" {{ old('id_discount') == $discount->id ? 'selected' : '' }}>
                                    {{ $discount->name }} ({{ $discount->value }}{{ $discount->type == 'percent' ? '%' : 'đ' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select class="form-select" id="status" name="status">
                            <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Hoạt động</option>
                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Ẩn</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Product Variants -->
            <div class="mb-4">
                <h5>Biến thể sản phẩm *</h5>
                <div id="variants-container">
                    <div class="variant-item border p-3 mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Tùy chọn (VD: Màu đỏ, Size M)</label>
                                <input type="text" class="form-control" name="variants[0][option]" 
                                       value="{{ old('variants.0.option') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Giá (đ)</label>
                                <input type="number" class="form-control" name="variants[0][price]" 
                                       value="{{ old('variants.0.price') }}" min="0" step="0.01" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Số lượng</label>
                                <input type="number" class="form-control" name="variants[0][stock]" 
                                       value="{{ old('variants.0.stock') }}" min="0" required>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-variant" disabled>
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" id="add-variant">
                    <i class="fas fa-plus"></i> Thêm biến thể
                </button>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Lưu sản phẩm
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
let variantIndex = 1;
let selectedFiles = [];

// Variant management
document.getElementById('add-variant').addEventListener('click', function() {
    const container = document.getElementById('variants-container');
    const newVariant = document.createElement('div');
    newVariant.className = 'variant-item border p-3 mb-3';
    newVariant.innerHTML = `
        <div class="row">
            <div class="col-md-4">
                <label class="form-label">Tùy chọn (VD: Màu đỏ, Size M)</label>
                <input type="text" class="form-control" name="variants[${variantIndex}][option]" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Giá (đ)</label>
                <input type="number" class="form-control" name="variants[${variantIndex}][price]" min="0" step="0.01" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Số lượng</label>
                <input type="number" class="form-control" name="variants[${variantIndex}][stock]" min="0" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-variant">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(newVariant);
    variantIndex++;
    updateRemoveButtons();
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-variant') || e.target.parentElement.classList.contains('remove-variant')) {
        const variantItem = e.target.closest('.variant-item');
        variantItem.remove();
        updateRemoveButtons();
    }
});

function updateRemoveButtons() {
    const variants = document.querySelectorAll('.variant-item');
    variants.forEach((variant, index) => {
        const removeBtn = variant.querySelector('.remove-variant');
        removeBtn.disabled = variants.length === 1;
    });
}

const uploadArea = document.getElementById('upload-area');
const imageInput = document.getElementById('images');
const imagePreview = document.getElementById('image-preview');

// Drag and drop
uploadArea.addEventListener('dragover', function(e) {
    e.preventDefault();
    uploadArea.classList.add('border-primary');
});

uploadArea.addEventListener('dragleave', function(e) {
    e.preventDefault();
    uploadArea.classList.remove('border-primary');
});

uploadArea.addEventListener('drop', function(e) {
    e.preventDefault();
    uploadArea.classList.remove('border-primary');
    
    const files = Array.from(e.dataTransfer.files);
    handleFiles(files);
});

// File input change
imageInput.addEventListener('change', function(e) {
    const files = Array.from(e.target.files);
    handleFiles(files);
});

function handleFiles(files) {
    // Limit to 5 images
    if (selectedFiles.length + files.length > 5) {
        alert('Chỉ được chọn tối đa 5 hình ảnh');
        return;
    }
    
    files.forEach(file => {
        if (file.type.startsWith('image/')) {
            selectedFiles.push(file);
            previewImage(file, selectedFiles.length - 1);
        }
    });
    
    updateFileInput();
}

function previewImage(file, index) {
    const reader = new FileReader();
    reader.onload = function(e) {
        const col = document.createElement('div');
        col.className = 'col-md-3 mb-3';
        col.innerHTML = `
            <div class="position-relative">
                <img src="${e.target.result}" class="img-fluid rounded" style="height: 150px; object-fit: cover; width: 100%;">
                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1" 
                        onclick="removeImage(${index})">
                    <i class="fas fa-times"></i>
                </button>
                ${index === 0 ? '<span class="badge bg-primary position-absolute bottom-0 start-0 m-1">Ảnh chính</span>' : ''}
            </div>
        `;
        imagePreview.appendChild(col);
    };
    reader.readAsDataURL(file);
}

function removeImage(index) {
    selectedFiles.splice(index, 1);
    updateFileInput();
    refreshPreview();
}

function updateFileInput() {
    const dt = new DataTransfer();
    selectedFiles.forEach(file => dt.items.add(file));
    imageInput.files = dt.files;
}

function refreshPreview() {
    imagePreview.innerHTML = '';
    selectedFiles.forEach((file, index) => {
        previewImage(file, index);
    });
}
</script>
@endpush
