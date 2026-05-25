````md
# ☕ Cafe Management System

<p align="center">
  <img src="https://laravel.com/img/logomark.min.svg" width="120" alt="Laravel Logo">
</p>

<h3 align="center">
  🚀 Website Quản Lý Quán Cafe Xây Dựng Bằng Laravel
</h3>

<p align="center">
  Hệ thống hỗ trợ quản lý hoạt động quán cafe hiện đại, trực quan và tối ưu hiệu suất.
</p>

---

# 📌 Giới Thiệu Dự Án

Cafe Management System là website quản lý quán cafe được xây dựng nhằm hỗ trợ:

✨ Quản lý sản phẩm  
✨ Quản lý menu đồ uống  
✨ Quản lý đơn hàng  
✨ Quản lý bàn  
✨ Quản lý khách hàng  
✨ Quản lý nhân viên  
✨ Thống kê doanh thu  
✨ Phân quyền quản trị  

Hệ thống được phát triển theo mô hình **MVC (Model - View - Controller)** sử dụng framework Laravel kết hợp MySQL giúp dễ dàng mở rộng và bảo trì.

---

# 🛠️ Công Nghệ Sử Dụng

<p align="center">

<img src="https://skillicons.dev/icons?i=laravel,php,mysql,bootstrap,html,css,js,git,github,vscode" />

</p>

| Công nghệ | Mô tả |
|---|---|
| Laravel | PHP Framework |
| MySQL | Hệ quản trị cơ sở dữ liệu |
| Bootstrap | Thiết kế giao diện |
| JavaScript | Xử lý tương tác |
| Git & GitHub | Quản lý source code |

---

# ⚙️ Chức Năng Chính

## 👨‍💼 Quản Trị Hệ Thống
- Đăng nhập / đăng xuất
- Phân quyền người dùng
- Quản lý tài khoản nhân viên

## 🍹 Quản Lý Sản Phẩm
- Thêm / sửa / xóa sản phẩm
- Quản lý giá bán
- Quản lý hình ảnh sản phẩm
- Quản lý danh mục

## 🪑 Quản Lý Bàn
- Theo dõi trạng thái bàn
- Đặt bàn
- Chuyển bàn

## 🧾 Quản Lý Đơn Hàng
- Tạo hóa đơn
- Thanh toán đơn hàng
- Theo dõi lịch sử giao dịch

## 📊 Thống Kê Doanh Thu
- Doanh thu theo ngày / tháng / năm
- Thống kê sản phẩm bán chạy
- Báo cáo doanh thu

---

# 🏗️ Kiến Trúc Hệ Thống

Dự án được xây dựng theo mô hình:

```bash
MVC (Model - View - Controller)
Client - Server Architecture
````

## 📂 Cấu Trúc Thư Mục

```bash
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

# 🚀 Hướng Dẫn Cài Đặt

## 1️⃣ Clone Project

```bash
git clone https://github.com/BuiTienDat29/Cafe_Management.git
```

## 2️⃣ Di Chuyển Vào Thư Mục Dự Án

```bash
cd Cafe_Management
```

## 3️⃣ Cài Đặt Thư Viện

```bash
composer install
```

## 4️⃣ Tạo File `.env`

```bash
cp .env.example .env
```

## 5️⃣ Generate App Key

```bash
php artisan key:generate
```

## 6️⃣ Cấu Hình Database

```env
DB_DATABASE=cafe_management
DB_USERNAME=root
DB_PASSWORD=
```

## 7️⃣ Chạy Migration

```bash
php artisan migrate
```

## 8️⃣ Khởi Động Server

```bash
php artisan serve
```

---

# 📸 Giao Diện Hệ Thống

✅ Trang đăng nhập
✅ Dashboard quản trị
✅ Quản lý sản phẩm
✅ Quản lý đơn hàng
✅ Thống kê doanh thu

---

# 🌟 Điểm Nổi Bật

✔️ Giao diện quản trị trực quan
✔️ Dễ dàng mở rộng tính năng
✔️ Chuẩn mô hình MVC
✔️ Quản lý dữ liệu hiệu quả
✔️ Tối ưu trải nghiệm người dùng

---

# 👨‍💻 Tác Giả

## Bùi Tiến Đạt

📧 Developer Laravel & Web Application

```
```
