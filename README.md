# ☕ Cafe Management System

Hệ thống quản lý quán cafe được xây dựng bằng framework Laravel nhằm hỗ trợ quản lý hoạt động bán hàng, sản phẩm, đơn hàng và nhân viên trong quán cafe một cách hiệu quả và hiện đại.

---

# 📌 Giới thiệu dự án

Cafe Management System là website quản lý quán cafe hỗ trợ:

* Quản lý sản phẩm / menu
* Quản lý danh mục món ăn & đồ uống
* Quản lý đơn hàng
* Quản lý bàn
* Quản lý khách hàng
* Quản lý nhân viên
* Thống kê doanh thu
* Phân quyền quản trị
* Giao diện quản trị trực quan

Hệ thống được xây dựng theo mô hình MVC sử dụng Laravel kết hợp MySQL nhằm đảm bảo khả năng mở rộng, bảo trì và tối ưu hiệu suất.

---

# 🚀 Công nghệ sử dụng

## Backend

* PHP
* Laravel
* RESTful API
* Eloquent ORM

## Frontend

* Blade Template
* HTML5
* CSS3
* JavaScript
* Bootstrap

## Database

* MySQL

## Công cụ hỗ trợ

* Composer
* Git & GitHub
* XAMPP / Laragon

---

# ⚙️ Chức năng chính

## 👨‍💼 Quản trị hệ thống

* Đăng nhập / đăng xuất
* Phân quyền người dùng
* Quản lý tài khoản nhân viên

## 🍹 Quản lý sản phẩm

* Thêm / sửa / xóa sản phẩm
* Quản lý giá bán
* Quản lý hình ảnh sản phẩm
* Quản lý danh mục

## 🪑 Quản lý bàn

* Theo dõi trạng thái bàn
* Đặt bàn
* Chuyển bàn

## 🧾 Quản lý đơn hàng

* Tạo hóa đơn
* Thanh toán đơn hàng
* Theo dõi lịch sử giao dịch

## 📊 Thống kê

* Doanh thu theo ngày / tháng / năm
* Thống kê sản phẩm bán chạy

---

# 🏗️ Kiến trúc hệ thống

Dự án được xây dựng theo mô hình:

* MVC (Model - View - Controller)
* Client - Server Architecture

Cấu trúc chính:

```bash id="t0w8sw"
app/
├── Http/
│   ├── Controllers/
│   └── Middleware/
├── Models/
resources/
├── views/
routes/
database/
public/
```

---

# 🛠️ Cài đặt dự án

## 1. Clone project

```bash id="fzppl2"
git clone https://github.com/BuiTienDat29/Cafe_Management.git
```

## 2. Di chuyển vào thư mục dự án

```bash id="0z1h48"
cd Cafe_Management
```

## 3. Cài đặt thư viện

```bash id="0s2w3g"
composer install
```

## 4. Tạo file môi trường

```bash id="oj74zc"
cp .env.example .env
```

## 5. Generate app key

```bash id="jlwmg6"
php artisan key:generate
```

## 6. Cấu hình database trong file `.env`

```env
DB_DATABASE=cafe_management
DB_USERNAME=root
DB_PASSWORD=
```

## 7. Chạy migration

```bash id="a3jlwm"
php artisan migrate
```

## 8. Khởi động server

```bash id="06yz5h"
php artisan serve
```

---

# 📷 Một số giao diện hệ thống

* Trang đăng nhập
* Dashboard quản trị
* Quản lý sản phẩm
* Quản lý đơn hàng
* Thống kê doanh thu

---

# 👨‍💻 Tác giả

* Bùi Tiến Đạt


