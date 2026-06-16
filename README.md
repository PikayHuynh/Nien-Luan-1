# 🧾 Hệ Thống Quản Lý Bán Hàng Công Nghệ (Tech Store Management)

Hệ thống quản lý bán hàng được thiết kế và xây dựng theo mô hình **MVC (Model-View-Controller)** chuyên sâu bằng ngôn ngữ **PHP thuần (Vanilla PHP)**. Dự án không chỉ là một trang web bán hàng đơn thuần mà còn là một giải pháp quản trị doanh nghiệp (ERP mini) tập trung vào tính chính xác của dữ liệu kho, tính linh hoạt của giá bán và trải nghiệm khách hàng cao cấp.

---

## 💎 1. Triết Lý Thiết Kế & Kiến Trúc

Dự án tuân thủ các nguyên tắc thiết kế phần mềm hiện đại nhằm đảm bảo khả năng mở rộng (Scalability) và bảo trì (Maintainability):
- **MVC Architecture**: Tách biệt hoàn toàn giữa Logic nghiệp vụ (Controller), Truy vấn dữ liệu (Model) và Hiển thị (View).
- **Front Controller Pattern**: Mọi yêu cầu đều đi qua `index.php`, giúp kiểm soát luồng dữ liệu, bảo mật và quản lý phiên làm việc tập trung.
- **Strong Typing & Validation**: Sử dụng kiểu dữ liệu mạnh trong các hàm Model và ép kiểu dữ liệu từ Request để tránh các lỗi logic tiềm ẩn.
- **Security First**: 
    - Sử dụng **PDO Prepared Statements** để chống lại SQL Injection.
    - Cơ chế **Password Hashing (Bcrypt)** cho toàn bộ tài khoản.
    - Xử lý **Exception Handling** tập trung, hiển thị trang lỗi 500 thay vì để lộ mã nguồn SQL.

---

## 🚀 2. Tính Năng Chi Tiết Hệ Thống

### 🛒 2.1 Khu Vực Khách Hàng (Client Side)
Hệ thống Client tập trung vào việc chuyển đổi (Conversion Rate) bằng các tính năng thông minh:

- **Hệ thống Gợi ý Sản phẩm (Smart Recommendation)**:
    - 🔥 **Sản phẩm HOT**: Hệ thống tự động phân tích bảng `CHUNG_TU_BAN_CT` để tìm ra các sản phẩm có số lượng bán ra `>= 5` trong vòng 30 ngày qua. Điều này đảm bảo danh sách sản phẩm HOT luôn được cập nhật theo xu hướng thực tế.
    - ✨ **Sản phẩm MỚI**: Sử dụng hàm thời gian trong SQL để lọc các mặt hàng được thêm vào hệ thống trong vòng 14 ngày gần nhất.
    - 🏷️ **Sản phẩm SALE**: Tự động nhận diện khi `GIAGOC` (giá niêm yết) lớn hơn giá bán thực tế. Hệ thống sẽ tính toán % giảm giá theo công thức: `(Giá gốc - Giá bán) / Giá gốc * 100`.

- **Quy trình Mua hàng & Thanh toán**:
    - **Giỏ hàng (Session-based)**: Lưu trữ sản phẩm trong phiên làm việc, cho phép cập nhật số lượng và tính toán tổng tiền tạm tính ngay lập tức.
    - **Checkout Logic**: Khi khách hàng nhấn thanh toán, hệ thống thực hiện 3 hành động đồng thời trong một Transaction:
        1. Tạo chứng từ bán (Master).
        2. Tạo chi tiết đơn hàng (Detail).
        3. Tự động tạo bản ghi tại bảng `KHO` để trừ tồn kho thực tế.

- **Đặc quyền VIP (VIP Loyalty Program)**:
    - Hệ thống tự động kiểm tra tổng chi tiêu của khách hàng trong 30 ngày. Nếu tổng số tiền đơn hàng đã hoàn tất vượt quá **30,000,000 đ**, khách hàng sẽ được gắn nhãn VIP và tự động được **giảm giá 20%** cho mọi đơn hàng tiếp theo.

### 👨‍💼 2.2 Khu Vực Quản Trị (Admin Panel)
Cung cấp công cụ quản lý 360 độ cho chủ cửa hàng:

- **Quản lý Kho hàng (Inventory Tracking)**:
    - Đây là module quan trọng nhất, sử dụng cơ chế **Transaction Logs**. Mọi hành vi nhập hàng (Chứng từ mua) hoặc bán hàng (Chứng từ bán) đều được ghi lại vào bảng `KHO`.
    - Admin có thể tra cứu lịch sử xuất/nhập của từng sản phẩm để đối soát khi có thất thoát.

- **Quản lý Giá (Dynamic Pricing)**:
    - Hệ thống cho phép thiết lập nhiều mức giá bán cho một sản phẩm theo thời điểm thông qua bảng `DON_GIA_BAN`. 
    - Sử dụng hàm `COALESCE` trong SQL để luôn lấy mức giá đang được đánh dấu là `APDUNG = 1` (Đang áp dụng), giúp Admin có thể lên lịch khuyến mãi trước.

- **Quản lý Chứng từ (Accounting)**:
    - Quản lý Master-Detail chuyên nghiệp. Admin có thể sửa đổi đơn hàng, hủy đơn hoặc cập nhật trạng thái vận chuyển. Khi trạng thái thay đổi, hệ thống có thể tích hợp thông báo cho người dùng.

---

## 🛠️ 3. Công Nghệ & Tiện Ích

- **Backend**: PHP 8.1+ (Hỗ trợ tốt nhất các tính năng mới).
- **Database**: MySQL 8.0 với các tính năng:
    - **Generated Columns**: Tự động tính toán `THANHTIEN` trong bảng chi tiết để giảm tải cho logic code.
    - **Indexes**: Tối ưu hóa truy vấn trên các cột `TEN_KH`, `TENHANGHOA` và các trường ngày tháng.
- **Frontend**: 
    - **Bootstrap 5**: Xây dựng layout nhanh và nhất quán.
    - **Vanilla JavaScript**: Xử lý các logic phía client như Validate Form, cập nhật giỏ hàng bằng AJAX/Fetch.
- **Utility Modules**:
    - `pagination.php`: Xử lý phân trang linh hoạt cho mọi bảng dữ liệu.
    - `searching.php`: Phân tích từ khóa tìm kiếm (Search Engine cơ bản).
    - `sorting.php`: Cung cấp các tiêu chí sắp xếp động cho danh sách sản phẩm.

---

## 🗄️ 4. Sơ Đồ Cơ Sở Dữ Liệu (Schema Overview)

| Tên Bảng | Vai trò & Chức năng |
| :--- | :--- |
| `KHACH_HANG` | Lưu trữ Profile, mật khẩu băm, và phân loại Admin/User/VIP. |
| `PHAN_LOAI` | Cấu trúc cây thư mục sản phẩm (Danh mục). |
| `HANG_HOA` | Thông tin gốc: Tên, Mô tả, Hình ảnh, Đơn vị tính và Số lượng hiện có. |
| `DON_GIA_BAN` | Lưu lịch sử biến động giá, dùng để tính toán Sale và lợi nhuận. |
| `CHUNG_TU_MUA` | Quản lý phiếu nhập hàng từ Nhà cung cấp. |
| `CHUNG_TU_BAN` | Quản lý đơn đặt hàng của khách. |
| `KHO` | Nhật ký vạn năng ghi lại mọi biến động số lượng hàng hóa. |

---

## 📂 5. Cấu Trúc Thư Mục Hệ Thống

```text
NienLuan1_HMP_237060014_18A/
│
├── index.php                 # Điểm khởi đầu duy nhất của ứng dụng
├── config/                   # Thư mục cấu hình (Database, Constants)
├── routes/                   # Hệ thống định tuyến web
│
├── controllers/              # Điều khiển logic nghiệp vụ
│   ├── CartController.php    # Logic giỏ hàng & thanh toán
│   ├── UserController.php    # Quản lý tài khoản khách hàng
│   ├── ChungTuBanController.php # Quản lý đơn hàng (Admin)
│   └── ...                   # Các controller khác
│
├── models/                   # Tầng tương tác Cơ sở dữ liệu (DAO)
│   ├── HangHoa.php           # Logic lấy sản phẩm Hot, Sale, New
│   ├── KhachHang.php         # Kiểm tra quyền VIP, Admin
│   └── ...                   # Các model tương ứng từng bảng
│
├── views/                    # Tầng hiển thị (Template Engine đơn giản)
│   ├── admin/                # Giao diện dành cho quản trị viên
│   ├── client/               # Giao diện dành cho người mua hàng
│   └── error/                # Các trang báo lỗi hệ thống
│
├── utils/                    # Các hàm tiện ích dùng chung
├── uploads/                  # Lưu trữ hình ảnh sản phẩm & avatar
└── script.sql                # File SQL tạo lập CSDL đầy đủ
```

---

## ⚙️ 6. Hướng Dẫn Cài Đặt (Step-by-step)

1. **Chuẩn bị Web Server**: Khuyến nghị sử dụng **Laragon** (PHP 8.x) để có hiệu năng tốt nhất.
2. **Triển khai Code**: Giải nén hoặc Clone mã nguồn vào thư mục `www`.
3. **Cấu hình Database**:
    - Truy cập `localhost/phpmyadmin`.
    - Tạo database mới tên là `quanly_banhang_2`.
    - Import file `script.sql`. Đảm bảo không có lỗi xảy ra trong quá trình import.
4. **Kết nối**: 
    - Mở file `config/database.php`.
    - Cập nhật `user`, `password` và `db_name` cho khớp với môi trường local.
5. **Cấp quyền thư mục**: Đảm bảo thư mục `uploads/` có quyền **Write** để hệ thống có thể lưu ảnh sản phẩm.

---

## 🔑 7. Thông Tin Đăng Nhập Mặc Định

- **Quản trị viên (Admin)**: 
  - Username: `admin`
  - Password: *(Vui lòng xem trong database hoặc dùng tính năng đăng ký nếu chưa có)*
- **Người dùng (User)**:
  - Username: `user`
  - Password: `123` (hoặc theo DB)

---

## 📜 8. Danh Sách Endpoint (Link API)

Hệ thống cung cấp một danh sách các đường dẫn chi tiết phục vụ cho việc kiểm thử và tra cứu nhanh. Vui lòng tham khảo file đính kèm: [api.txt](file:///d:/laragon/www/NienLuan1_HMP_237060014_18A/api.txt).

---

## 🛡️ 9. Bảo Mật & Tối Ưu

- **SQL Injection**: Toàn bộ query sử dụng `prepare` và `execute` với tham số hóa.
- **XSS Protection**: Dữ liệu hiển thị ra View luôn được bọc qua hàm `htmlspecialchars()`.
- **Performance**: 
    - Sử dụng `JOIN` thay vì chạy nhiều query đơn lẻ trong vòng lặp.
    - Cache kết quả truy vấn vào Session nếu dữ liệu ít biến động.
- **Scalability**: Cấu trúc Model dễ dàng chuyển đổi sang các thư viện ORM như Eloquent hoặc Doctrine sau này.

---

## 🛠️ 10. Hướng Dẫn Phát Triển (Developer Guide)

Nếu bạn muốn mở rộng hệ thống hoặc thêm một tính năng mới (ví dụ: Quản lý Nhà Cung Cấp), hãy làm theo các bước sau:

1.  **Database**: Tạo bảng `NHA_CUNG_CAP` trong MySQL với các trường cần thiết.
2.  **Model**: Tạo file `models/NhaCungCap.php`. Xây dựng các hàm CRUD (Create, Read, Update, Delete). Đảm bảo sử dụng PDO và bọc logic trong các khối `try-catch`.
3.  **Controller**: Tạo `controllers/NhaCungCapController.php`. Gọi model và xử lý các Request. Lưu ý kiểm tra quyền Admin ở đầu constructor.
4.  **View**: Tạo thư mục `views/admin/nhacungcap/` và các file `list.php`, `create.php`, `edit.php`. Sử dụng layout chung trong `layouts/`.
5.  **Route**: Khai báo route mới trong `routes/web.php` hoặc `index.php` để hệ thống nhận diện controller.

---

## ❓ 11. Câu Hỏi Thường Gặp (FAQ)

**Hỏi: Tại sao giá sản phẩm trên trang chủ hiển thị 0 đ?**
*Trả lời: Điều này thường xảy ra khi sản phẩm chưa được thiết lập giá trong bảng `DON_GIA_BAN`. Admin cần vào mục Quản lý Đơn Giá để cập nhật giá trị áp dụng.*

**Hỏi: Làm sao để thay đổi ngưỡng đạt chuẩn VIP?**
*Trả lời: Bạn có thể thay đổi tham số `$limit` trong hàm `checkVip()` tại file `models/KhachHang.php`.*

**Hỏi: Hệ thống có hỗ trợ thanh toán Online không?**
*Trả lời: Hiện tại phiên bản này hỗ trợ thanh toán khi nhận hàng (COD). Tuy nhiên, với cấu trúc MVC hiện tại, bạn có thể dễ dàng tích hợp thêm các cổng như VNPay hoặc MoMo vào `CartController`.*

**Hỏi: Hình ảnh tải lên không hiển thị?**
*Trả lời: Hãy kiểm tra xem thư mục `uploads/` đã được cấp quyền ghi (Write) chưa và đường dẫn trong DB có khớp với cấu trúc thư mục không.*

---

## 📅 12. Lộ Trình Phát Triển (Roadmap)

- [ ] Tích hợp thông báo qua Email khi đơn hàng được duyệt.
- [ ] Xây dựng hệ thống Chat trực tuyến giữa Admin và Khách hàng.
- [ ] Phát triển ứng dụng Mobile (API-based) sử dụng chung Backend.
- [ ] Tích hợp AI để gợi ý sản phẩm dựa trên hành vi xem trang của người dùng.

---
**Tác giả**: Principal Engineer / Solution Architect
**Phiên bản**: 2.1.0 (Bản nâng cấp Kho & VIP)
**Liên hệ**: Support Project Team
**Bản quyền**: © 2026 Tech Store Management System. All rights reserved.
