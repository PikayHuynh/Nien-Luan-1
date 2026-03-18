# 🧾 Giới thiệu

Hệ thống quản lý bán hàng được xây dựng theo mô hình MVC thuần PHP bao gồm:
- **Trang Admin**: quản lý khách hàng, sản phẩm, phân loại, thuộc tính, giá bán, chứng từ mua – bán, quản lý kho.
- **Trang Client**: xem sản phẩm, mua hàng, giỏ hàng, thanh toán, tài khoản người dùng, xem lịch sử đơn hàng.
- Có phân quyền cơ bản và giao diện tách biệt giữa Admin và Client.
- Cấu trúc rõ ràng, dễ mở rộng và dễ bảo trì.

## 🗄️ Cấu trúc Database

Tạo database bằng câu lệnh:
```sql
CREATE DATABASE IF NOT EXISTS quanly_banhang_2 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE quanly_banhang_2;
```

Các bảng chính trong hệ thống:
| Bảng            | Mô tả                                          |
| --------------- | ---------------------------------------------- |
| KHACH_HANG      | Lưu thông tin khách hàng & tài khoản đăng nhập |
| PHAN_LOAI       | Danh mục sản phẩm                              |
| HANG_HOA        | Sản phẩm & số lượng tồn kho                    |
| THUOC_TINH      | Thuộc tính của từng sản phẩm                   |
| DON_GIA_BAN     | Lưu lịch sử giá bán                            |
| CHUNG_TU_MUA    | Lưu hóa đơn nhập hàng                          |
| CHUNG_TU_MUA_CT | Chi tiết hóa đơn nhập                          |
| CHUNG_TU_BAN    | Lưu hóa đơn bán hàng                           |
| CHUNG_TU_BAN_CT | Chi tiết hóa đơn bán                           |
| KHO             | Lịch sử giao dịch nhập/xuất kho                |

## 🔐 Tài khoản đăng nhập mặc định

| Tài khoản | Mật khẩu                    | Quyền |
| --------- | --------------------------- | ----- |
| **admin** | *(Mặc định trong database)* | ADMIN |

*(Để đổi mật khẩu → chỉnh trong bảng `KHACH_HANG`)*

## 🚀 Cách cài đặt và chạy dự án

1. **Copy toàn bộ project** vào thư mục web server (ví dụ: `C:\laragon\www\quanly_banhang`).
2. **Tạo Database**: Vào phpMyAdmin → Import → chọn file `script.sql`. Đừng quên chạy file `database_update.sql` để cập nhật bảng `Kho` và cột `SoLuong` mới nhất.
3. **Cấu hình kết nối CSDL**: Mở file `config/database.php` và cấu hình các thông số phù hợp:
    ```php
    return [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => '',
        'db'   => 'quanly_banhang_2',
    ];
    ```
4. **Truy cập hệ thống**:
    - **Client**: Đường dẫn gốc, ví dụ: `http://localhost/quanly_banhang`
    - **Admin**: Qua route, ví dụ: `http://localhost/quanly_banhang/index.php?controller=dashboard&action=index`

## 🛠️ Các tính năng chi tiết của Hệ thống

### 👨‍💼 KHU VỰC ADMIN (Quản trị viên)

1. **Dashboard (Bảng điều khiển & Thống kê)**
   - Xem tổng quan các chỉ số: Số lượng khách hàng, số lượng đơn hàng, số lượng sản phẩm.
   - Thống kê doanh thu, trạng thái các chứng từ mua bán của cửa hàng.
2. **Quản lý Hàng Hóa (Sản phẩm)**
   - Xem danh sách sản phẩm với giao diện bảng, có phân trang, lọc và tìm kiếm theo tên.
   - Thêm mới, Sửa, Xóa thông tin sản phẩm (Tên, mô tả, đơn vị tính, hình ảnh).
   - Module upload và quản lý lưu trữ hình ảnh sản phẩm. Hiển thị nhãn HOT/NEW/SALE ngay trong bảng Admin để theo dõi.
3. **Quản lý Kho hàng (Nhập/Xuất)**
   - Module **độc lập** mới nhất: Lưu vết (Lịch sử) mọi biến động số lượng của kho.
   - Khi Admin duyệt/lập **Chứng từ Mua**, số lượng kho và thuộc tính `SOLUONG` tự động được (+) cộng thêm (Nhập Kho).
   - Khi Khách thanh toán đơn đặt hoặc Admin lập **Chứng từ Bán**, số lượng lập tức được (-) trừ đi (Xuất Kho).
   - Giao diện lịch sử nhập/xuất kho hiển thị rõ mã chứng từ liên quan và ngày giờ phát sinh.
4. **Quản lý Phân loại (Danh mục) & Thuộc tính**
   - Phân loại (Categories): Tạo, sửa, xóa các nhóm danh mục chính.
   - Thuộc tính (Attributes): Thêm bớt và phân loại thuộc tính động của các nhóm mặt hàng khác nhau.
5. **Quản lý Đơn Giá Bán**
   - Thiết lập giá bán, giá gốc cho từng sản phẩm từng thời điểm.
   - Hệ thống so sánh giá gốc và giá hiện hành để tự động xuất nhãn "% Giảm giá (Sale)" phía Client.
6. **Quản lý Khách Hàng / Tài Khoản**
   - Xem danh sách và thông tin người dùng đã đăng ký.
   - Cấp tài khoản mới, phân quyền (Quyền ADMIN hoặc USER) cho hệ thống để giới hạn truy cập.
7. **Quản lý Chứng Từ (Hóa Đơn / Vận đơn)**
   - **Chứng từ Mua (Nhập hàng):** Lập phiếu cho nhà cung cấp, lưu chi tiết hàng nhập, số lượng, giá tiền nhập.
   - **Chứng từ Bán (Xuất bán):** Nơi gom mọi đơn hàng từ Client đẩy về. Admin dùng để quản lý trạng thái thanh toán, thống kê doanh thu và tra soát lịch sử mua của user.

### 🛒 KHU VỰC CLIENT (Người mua hàng)

1. **Giao diện Trang chủ (Home)**
   - Banner giới thiệu trực quan, hiện đại cùng khối thống kê hệ thống (tổng sp, danh mục).
   - Hệ thống gợi ý **Thông minh** – hoàn toàn lấy số liệu chuẩn từ Database:
     - **Sản phẩm HOT:** Tự tìm 8 sản phẩm bán chạy nhất (**có phát sinh > 5 lượt mua** trong 30 ngày qua).
     - **Sản phẩm NEW:** Tự nhận diện và gắn nhãn các hàng hóa đăng tải trong **14 ngày gần nhất**.
     - **Sản phẩm SALE:** Tự động tính tỷ lệ giảm giá từ bảng giá và gắn thẻ highlight trực quan.
2. **Tìm kiếm & Lọc Sản Phẩm**
   - Phân trang Grid View sản phẩm chuyên nghiệp.
   - Khung Searchbox cho phép tra cứu ngay theo Tên hoặc Từ khóa mô tả.
   - Bộ lọc chi tiết: Lọc theo khoảng giá (Từ X - Đến Y VNĐ) và Lọc theo Danh mục.
   - Sắp xếp (Sorting): Giá tăng dần, Giá giảm dần, Hàng Khuyến mãi, Hàng Mới Nhất.
3. **Chi tiết Sản phẩm**
   - Tối ưu UI hiển thị ảnh mô tả lớn, giá sale gạch chéo, % chiết khấu kèm các phân loại hàng hóa rõ ràng.
   - Checkbox hoặc khối hành động cho phép người dùng thêm ngay vào Giỏ hàng.
4. **Giỏ hàng & Thanh toán (Cart & Checkout)**
   - Hệ thống lưu phiên (Session) giỏ hàng. Thêm, Sửa (tăng/giảm) số lượng linh hoạt, Xóa mặt hàng khỏi giỏ.
   - Tính toán và cộng dồn **Tổng tiền giỏ hàng** (Tổng phụ).
   - Chức năng **Thanh toán (Checkout)**: Check quyền đăng nhập an toàn, chuyển thể Giỏ hàng sang "Chứng từ Bán" lưu DB và tạo giao dịch xuất kho để trừ số lượng tương ứng. Đã xử lý nguyên lý giỏ trống chặn thanh toán.
5. **Trang cá nhân (Profile) & Authenticate**
   - **Đăng ký / Đăng nhập (Auth)** và Giữ phiên đăng nhập lâu dài. Phân loại Admin tự động.
   - Màn hình cá nhân (Profile): Cập nhật thông tin khách hàng, xem trạng thái **Lịch sử đặt hàng** của riêng User đó.
6. **Xử lý Lỗi & Exception Handling (Bảo đảm Backend)**
   - Các controller đều chặn các Request không chuẩn.
   - **Trang 404:** Layout thân thiện, dẫn đường khi Khách nhập sai hoặc mất trang.
   - **Trang 500 (Exception Handler):** Bắt cứng các lỗi truy vấn, sập máy chủ SQL hoặc lỗi Logic hàm để xuất màn hình Internal Server Error sang trọng, che chắn lộ lọt DB ra ngoài cho User nhằm tăng độ bảo mật.

## 🧩 Công nghệ & Tiện ích sử dụng

- **Công nghệ chính**: PHP thuần (MVC tự xây dựng), MySQL, Bootstrap 5, HTML/CSS/JS, Session-based Auth.
- **Tiện ích (Utils/Modules)**:
  - Phân trang (`pagination.php`)
  - Tìm kiếm (`searching.php`)
  - Sắp xếp (`sorting.php`)
- **JavaScript Validate Form**: Validate Client (Login, Register) và Admin (Create, Update).
- **KHÔNG dùng framework PHP**: Giúp dễ học, kiểm soát cấu trúc và dễ tùy biến.

## 📁 Cấu trúc thư mục dự án

```text
quanly_banhang/
│
├── index.php                 # File khởi động chính (Front Controller)
│
├── config/
│   └── database.php          # Cấu hình kết nối MySQL
│
├── routes/
│   └── web.php               # Khai báo toàn bộ route của hệ thống
│
├── controllers/              # Điều khiển logic (Controller Layer)
│   ├── DashboardController.php
│   ├── CartController.php
│   ├── UserController.php
│   ├── KhachHangController.php
│   ├── PhanLoaiController.php
│   ├── HangHoaController.php
│   ├── ThuocTinhController.php
│   ├── DonGiaBanController.php
│   ├── ChungTuMuaController.php
│   ├── ChungTuMuaCTController.php
│   ├── ChungTuBanController.php
│   ├── ChungTuBanCTController.php
│   └── KhoController.php     # Controller quản lý kho
│
├── models/                   # Tầng truy vấn dữ liệu (Model Layer)
│   ├── KhachHang.php
│   ├── PhanLoai.php
│   ├── HangHoa.php
│   ├── ThuocTinh.php
│   ├── DonGiaBan.php
│   ├── ChungTuMua.php
│   ├── ChungTuMuaCT.php
│   ├── ChungTuBan.php
│   ├── ChungTuBanCT.php
│   └── Kho.php               # Model xử lý Nhập/Xuất kho
│
├── views/                    # Tầng giao diện (View Layer)
│   ├── admin/                # Giao diện Admin
│   │   ├── dashboard/
│   │   ├── khachhang/
│   │   ├── hanghoa/
│   │   ├── thuoctinh/
│   │   ├── dongiaban/
│   │   ├── chungtumua/
│   │   ├── chungtuban/
│   │   ├── kho/
│   │   └── layouts/          # Header / Footer / Sidebar Admin
│   │
│   ├── client/               # Giao diện Client (Người dùng)
│   │   ├── home/
│   │   ├── product/
│   │   ├── cart/
│   │   ├── user/
│   │   └── layouts/          # Header / Footer Client
│   │
│   └── error/                # Các trang báo lỗi hệ thống (403, 404, 500)
│       └── 500.php
│  
├── utils/                    # Các module hỗ trợ
│   ├── pagination.php        # Code phân trang dùng chung
│   ├── searching.php         # Code phân tích chuỗi tìm kiếm
│   └── sorting.php           # Logic Sắp xếp
│
├── uploads/                  # Thư mục lưu ảnh người dùng / sản phẩm tải lên
├── script.sql                # File SQL tạo lập toàn bộ database gốc ban đầu
└── database_update.sql       # File SQL nâng cấp bảng KHO và cột SOLUONG
```
