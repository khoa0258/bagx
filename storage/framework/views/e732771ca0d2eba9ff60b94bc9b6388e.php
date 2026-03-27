<?php $__env->startSection('title', 'Chỉnh sửa sản phẩm'); ?>
<?php $__env->startSection('page-title', 'Chỉnh sửa sản phẩm: ' . $product->name); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('admin.products.update', $product)); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên sản phẩm *</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="name" name="name" value="<?php echo e(old('name', $product->name)); ?>" required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  id="description" name="description" rows="5"><?php echo e(old('description', $product->description)); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Thêm section quản lý hình ảnh -->
                    <div class="mb-4">
                        <label class="form-label">Hình ảnh sản phẩm</label>
                        
                        <!-- Hiển thị hình ảnh hiện có -->
                        <?php if($product->images->count() > 0): ?>
                            <div class="mb-3">
                                <h6>Hình ảnh hiện có:</h6>
                                <div class="row" id="existing-images">
                                    <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-md-3 mb-3" id="existing-image-<?php echo e($image->id); ?>">
                                            <div class="position-relative">
                                                <img src="<?php echo e(asset($image->img_url)); ?>" class="img-fluid rounded" 
                                                     style="height: 150px; object-fit: cover; width: 100%;">
                                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1" 
                                                        onclick="removeExistingImage(<?php echo e($image->id); ?>)">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                <?php if($image->is_primary): ?>
                                                    <span class="badge bg-primary position-absolute bottom-0 start-0 m-1">Ảnh chính</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Upload hình ảnh mới -->
                        <div class="upload-area border-2 border-dashed border-secondary rounded p-4 text-center" 
                             id="upload-area" style="min-height: 200px;">
                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-2">Kéo thả hình ảnh mới vào đây hoặc click để chọn</p>
                            <p class="text-muted small">Tối đa 5 hình ảnh, định dạng: JPG, PNG, GIF (Max: 2MB/hình)</p>
                            <input type="file" id="images" name="images[]" multiple accept="image/*" class="d-none">
                            <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('images').click()">
                                <i class="fas fa-plus"></i> Chọn hình ảnh mới
                            </button>
                        </div>
                        <?php $__errorArgs = ['images'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        
                        <!-- Preview hình ảnh mới -->
                        <div id="image-preview" class="row mt-3"></div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="id_category" class="form-label">Danh mục *</label>
                        <select class="form-select <?php $__errorArgs = ['id_category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="id_category" name="id_category" required>
                            <option value="">Chọn danh mục</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" 
                                    <?php echo e(old('id_category', $product->id_category) == $category->id ? 'selected' : ''); ?>>
                                    <?php echo e($category->mainCategory->name); ?> - <?php echo e($category->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['id_category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="id_brand" class="form-label">Thương hiệu *</label>
                        <select class="form-select <?php $__errorArgs = ['id_brand'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="id_brand" name="id_brand" required>
                            <option value="">Chọn thương hiệu</option>
                            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($brand->id); ?>" 
                                    <?php echo e(old('id_brand', $product->id_brand) == $brand->id ? 'selected' : ''); ?>>
                                    <?php echo e($brand->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['id_brand'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="id_discount" class="form-label">Khuyến mãi</label>
                        <select class="form-select" id="id_discount" name="id_discount">
                            <option value="">Không có</option>
                            <?php $__currentLoopData = $discounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $discount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($discount->id); ?>" 
                                    <?php echo e(old('id_discount', $product->id_discount) == $discount->id ? 'selected' : ''); ?>>
                                    <?php echo e($discount->name); ?> (<?php echo e($discount->value); ?><?php echo e($discount->type == 'percent' ? '%' : 'đ'); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select class="form-select" id="status" name="status">
                            <option value="1" <?php echo e(old('status', $product->status) == 1 ? 'selected' : ''); ?>>Hoạt động</option>
                            <option value="0" <?php echo e(old('status', $product->status) == 0 ? 'selected' : ''); ?>>Ẩn</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Product Variants -->
            <div class="mb-4">
                <h5>Biến thể sản phẩm *</h5>
                <div id="variants-container">
                    <?php $__currentLoopData = $product->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="variant-item border p-3 mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Tùy chọn (VD: Màu đỏ, Size M)</label>
                                    <input type="text" class="form-control" name="variants[<?php echo e($index); ?>][option]" 
                                           value="<?php echo e(old('variants.'.$index.'.option', $variant->option)); ?>" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Giá (đ)</label>
                                    <input type="number" class="form-control" name="variants[<?php echo e($index); ?>][price]" 
                                           value="<?php echo e(old('variants.'.$index.'.price', $variant->price)); ?>" min="0" step="0.01" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Số lượng</label>
                                    <input type="number" class="form-control" name="variants[<?php echo e($index); ?>][stock]" 
                                           value="<?php echo e(old('variants.'.$index.'.stock', $variant->stock)); ?>" min="0" required>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger remove-variant" 
                                        <?php echo e(count($product->variants) === 1 ? 'disabled' : ''); ?>>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <button type="button" class="btn btn-secondary" id="add-variant">
                    <i class="fas fa-plus"></i> Thêm biến thể
                </button>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Cập nhật sản phẩm
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
let variantIndex = <?php echo e(count($product->variants)); ?>;
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
    // Limit to 5 images total
    const existingCount = document.querySelectorAll('#existing-images .col-md-3').length;
    if (existingCount + selectedFiles.length + files.length > 5) {
        alert('Chỉ được có tối đa 5 hình ảnh cho mỗi sản phẩm');
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
                        onclick="removeNewImage(${index})">
                    <i class="fas fa-times"></i>
                </button>
                <span class="badge bg-success position-absolute bottom-0 start-0 m-1">Mới</span>
            </div>
        `;
        imagePreview.appendChild(col);
    };
    reader.readAsDataURL(file);
}

function removeNewImage(index) {
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

// Xóa hình ảnh hiện có
function removeExistingImage(imageId) {
    if (confirm('Bạn có chắc muốn xóa hình ảnh này?')) {
        fetch(`/admin/images/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`existing-image-${imageId}`).remove();
            } else {
                alert('Có lỗi xảy ra khi xóa hình ảnh');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi xóa hình ảnh');
        });
    }
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/bagxidvn/public_html/resources/views/admin/products/edit.blade.php ENDPATH**/ ?>