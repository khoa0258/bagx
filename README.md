# Laravel E-commerce Application

Ứng dụng thương mại điện tử được xây dựng bằng Laravel 11 với đầy đủ chức năng admin panel và giao diện người dùng.

## Tính năng

### Admin Panel
- Dashboard với thống kê tổng quan
- Quản lý sản phẩm (CRUD) với biến thể và hình ảnh
- Quản lý danh mục phân cấp (danh mục chính và con)
- Quản lý đơn hàng với cập nhật trạng thái
- Quản lý thương hiệu và khuyến mãi

### Giao diện người dùng
- Trang chủ với sản phẩm nổi bật và mới
- Danh sách sản phẩm với bộ lọc và tìm kiếm
- Chi tiết sản phẩm với carousel hình ảnh
- Giỏ hàng với session storage
- Quy trình thanh toán đầy đủ
- Quản lý đơn hàng cá nhân

### Hệ thống
- Authentication với roles (user/admin)
- Responsive design với Bootstrap 5
- Quản lý tồn kho tự động
- Hỗ trợ nhiều phương thức thanh toán

## Yêu cầu hệ thống

- PHP >= 8.2
- Composer
- MySQL/MariaDB
- XAMPP (khuyến nghị)

## Cài đặt

### 1. Clone dự án
\`\`\`bash
git clone <repository-url>
cd laravel-ecommerce
\`\`\`

### 2. Cài đặt dependencies
\`\`\`bash
composer install
\`\`\`

### 3. Cấu hình môi trường
\`\`\`bash
cp .env.example .env
php artisan key:generate
\`\`\`

### 4. Cấu hình database trong file `.env`
\`\`\`env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bagxdb
DB_USERNAME=root
DB_PASSWORD=
\`\`\`

### 5. Import database
- Tạo database `bagxdb` trong phpMyAdmin
- Import file SQL đã cung cấp vào database

### 6. Chạy migrations bổ sung
\`\`\`bash
php artisan migrate
\`\`\`

### 7. Seed dữ liệu cơ bản
\`\`\`bash
php artisan db:seed
\`\`\`

### 8. Tạo symbolic link cho storage
\`\`\`bash
php artisan storage:link
\`\`\`

### 9. Chạy ứng dụng
\`\`\`bash
php artisan serve
\`\`\`

Truy cập: http://localhost:8000

## Tài khoản mặc định

### Admin
- Email: admin@example.com
- Password: password

### User
- Email: user@example.com  
- Password: password

## Cấu trúc thư mục

\`\`\`
app/
├── Http/Controllers/
│   ├── Admin/           # Controllers cho admin panel
│   ├── CartController.php
│   ├── CheckoutController.php
│   └── ...
├── Models/              # Eloquent models
└── Http/Middleware/     # Custom middleware

resources/views/
├── admin/               # Views cho admin panel
├── frontend/            # Views cho giao diện người dùng
├── auth/                # Views authentication
└── layouts/             # Layout templates

database/
├── migrations/          # Database migrations
└── seeders/            # Database seeders

routes/
└── web.php             # Web routes
\`\`\`

## API Routes

### Frontend
- `GET /` - Trang chủ
- `GET /products` - Danh sách sản phẩm
- `GET /products/{slug}` - Chi tiết sản phẩm
- `GET /cart` - Giỏ hàng
- `POST /cart/add` - Thêm vào giỏ hàng
- `GET /checkout` - Thanh toán
- `GET /orders` - Đơn hàng của tôi

### Admin (prefix: /admin)
- `GET /` - Dashboard
- `GET /products` - Quản lý sản phẩm
- `GET /categories` - Quản lý danh mục
- `GET /orders` - Quản lý đơn hàng

## Tùy chỉnh

### Thêm phương thức thanh toán
1. Thêm record vào bảng `payments`
2. Cập nhật logic xử lý trong `CheckoutController`

### Thêm thuộc tính sản phẩm
1. Sử dụng bảng `attribute_products` có sẵn
2. Thêm form input trong admin panel

### Tùy chỉnh giao diện
- CSS tùy chỉnh trong `resources/views/layouts/app.blade.php`
- Sử dụng Bootstrap 5 classes
- Tùy chỉnh màu sắc trong CSS variables

## Troubleshooting

### Lỗi 500 - Internal Server Error
- Kiểm tra file `.env` đã được cấu hình đúng
- Chạy `php artisan config:clear`
- Kiểm tra quyền thư mục storage và bootstrap/cache

### Lỗi database connection
- Kiểm tra MySQL service đã chạy
- Xác nhận thông tin database trong `.env`
- Tạo database nếu chưa có

### Lỗi composer install
- Cập nhật Composer: `composer self-update`
- Xóa vendor và chạy lại: `rm -rf vendor && composer install`

## Đóng góp

1. Fork dự án
2. Tạo feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Tạo Pull Request

## License

Dự án này được phân phối dưới MIT License. Xem file `LICENSE` để biết thêm chi tiết.

## Hỗ trợ

Nếu bạn gặp vấn đề hoặc có câu hỏi, vui lòng tạo issue trên GitHub repository.
