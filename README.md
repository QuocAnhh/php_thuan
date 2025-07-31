# Tuyển sinh Đại học 

## Chức năng

- **Xác thực người dùng**: Hệ thống đăng ký và đăng nhập đơn giản, an toàn cho sinh viên và quản trị viên.
- **Trang tổng quan Sinh viên**: Người dùng có thể tạo, nộp, và xem hồ sơ xét tuyển của mình.
- **Form Hồ sơ Động**: Người dùng có thể thêm nhiều "nguyện vọng" (lựa chọn ngành học) vào hồ sơ một cách linh hoạt.
- **Tải lên Tập tin**: Người dùng có thể tải lên các tài liệu cần thiết (ví dụ: học bạ, giấy chứng nhận).
- **Bảng điều khiển Admin**:
  - **Quản lý Ngành học**: Admin có thể thực hiện các thao tác CRUD (Tạo, Đọc, Cập nhật, Xóa) đối với các ngành học của trường.
  - **Quản lý Hồ sơ**: Admin có thể xem tất cả hồ sơ đã nộp, kiểm tra chi tiết, và cập nhật trạng thái (Đã duyệt, Đã từ chối, Đang chờ).
- **Routing Đơn giản**: Một router thủ tục (procedural) cơ bản xử lý tất cả các yêu cầu.
- **Mã nguồn Thủ tục**: Codebase chủ yếu sử dụng PHP theo lối lập trình thủ tục với phần mở rộng `mysqli` để tương tác với cơ sở dữ liệu, giúp người mới bắt đầu dễ dàng tìm hiểu.

## Cấu trúc Dự án

```
/
├── config/
│   └── config.php         # kết nối db
├── public/
│   ├── css/style.css      # css
│   ├── uploads/           # docs mà user upload
│   ├── auth/              # log in, log out
│   ├── majors/            # manage major (admin)
│   ├── applications/      # submit application (user)
│   ├── admin/             # manage application (admin)
│   └── index.php          # điểm vào chính và router
├── aboutController.php
├── adminController.php
├── applicationController.php
├── authController.php
├── dashboardController.php
├── homeController.php
├── majorController.php
├── database.sql           # config db
└── README.md              # file này
```

## Hướng dẫn Cài đặt và Chạy

### 1. Yêu cầu

- [XAMPP](https://www.apachefriends.org/index.html) hoặc bất kỳ máy chủ cục bộ nào khác hỗ trợ PHP và MySQL.

### 2. Các bước Cài đặt

1.  **Tải về dự án**:
    - Tải mã nguồn về dưới dạng file ZIP và giải nén.
    - Hoặc dùng Git:
    ```bash
    git clone https://github.com/QuocAnhh/php_thuan.git
    cd php_thuan
    ```

2.  **Khởi động XAMPP**: Đảm bảo các dịch vụ Apache và MySQL đang chạy.

3.  **Tạo Cơ sở dữ liệu**:
    - Mở phpMyAdmin (thường ở địa chỉ `http://localhost/phpmyadmin`).
    - Tạo một cơ sở dữ liệu mới có tên là `backend_web_db`.
    - **Quan trọng**: Nếu bạn đã có sẵn database, hãy chắc chắn rằng cấu trúc của nó (tên bảng, tên cột) khớp với file `database.sql`. Nếu không, hãy cân nhắc sử dụng một database mới và import file `database.sql` để đảm bảo tương thích.
    - Để tạo mới, chọn cơ sở dữ liệu vừa tạo và chuyển đến tab "Import" (Nhập).
    - Nhấp vào "Choose File" (Chọn tệp) và tìm đến tệp `database.sql` trong thư mục gốc của dự án.
    - Nhấp vào "Go" (Thực hiện) để nhập cấu trúc cơ sở dữ liệu.

4.  **Cấu hình Cơ sở dữ liệu**:
    - Mở tệp `config/config.php`.
    - Nếu thông tin đăng nhập MySQL của bạn khác với mặc định (tên người dùng `root` và không có mật khẩu), hãy cập nhật các hằng số `DB_USER` và `DB_PASS`.

5.  **Chạy Dự án**:
    - **Sử dụng Server tích hợp của PHP (Khuyến khích)**:
      - Mở terminal (dòng lệnh) và điều hướng đến thư mục `public/`:
        ```bash
        cd public
        ```
      - Khởi động server:
        ```bash
        php -S localhost:8000
        ```
      - Mở trình duyệt web và truy cập `http://localhost:8000`.

    - **Sử dụng thư mục `htdocs` của XAMPP**:
      - Sao chép toàn bộ thư mục dự án vào thư mục `htdocs` của XAMPP.
      - Mở trình duyệt web và điều hướng đến `http://localhost/<tên-thư-mục-dự-án>/public`.

### 3. Tài khoản Admin Mặc định

Sau khi config db, bạn có thể đăng ký một tài khoản mới. Để cấp quyền admin cho một tài khoản, bạn cần chỉnh sửa thủ công cột `is_admin` cho người dùng đó trong bảng `users` thông qua phpMyAdmin. Thay đổi giá trị từ `0` thành `1`. 