# 🎓 BTL Web - Backend API Documentation

## 🌐 Server Information

**Backend URL:** `http://localhost/btl-web`  
**Port:** `80` (Apache - XAMPP)  
**Technology:** PHP + MySQL  
**Auth Method:** Session-based  

---

## 🔐 Authentication Endpoints

### Login
```
POST /btl-web/login
Content-Type: application/x-www-form-urlencoded

Body:
email=admin@example.com&password=password
```

### Register
```
POST /btl-web/register
Content-Type: application/x-www-form-urlencoded

Body:
name=User Name&email=user@example.com&password=password
```

### Logout
```
GET /btl-web/logout
```

### Check Authentication
```
GET /btl-web/dashboard
// Redirect to login nếu chưa đăng nhập
```

---

## 👨‍💼 Admin Endpoints

### Quản lý Ngành học

#### Danh sách ngành
```
GET /btl-web/majors
Response: HTML table hoặc thêm ?format=json cho JSON
```

#### Tạo ngành mới  
```
GET /btl-web/majors/create
Response: Form HTML để tạo ngành
```

```
POST /btl-web/majors/create
Content-Type: application/x-www-form-urlencoded

Body:
code=IT01&name=Công nghệ thông tin&description=Mô tả ngành
```

#### Sửa ngành
```
GET /btl-web/majors/edit?id=1
Response: Form HTML để sửa ngành
```

```
POST /btl-web/majors/update
Content-Type: application/x-www-form-urlencoded

Body:
id=1&code=IT01&name=New Name&description=New Description
```

#### Xóa ngành
```
GET /btl-web/majors/delete?id=1
```

### Quản lý Hồ sơ

#### Danh sách hồ sơ
```
GET /btl-web/admin/applications
Response: HTML list hoặc thêm ?format=json cho JSON
```

#### Chi tiết hồ sơ
```
GET /btl-web/admin/applications/show?id=1
Response: HTML chi tiết hồ sơ
```

#### Cập nhật trạng thái hồ sơ
```
POST /btl-web/admin/applications/update-status
Content-Type: application/x-www-form-urlencoded

Body:
id=1&status=approved
// status: pending, processing, approved, rejected
```

---

## 👨‍🎓 Student Endpoints

### Hồ sơ tuyển sinh

#### Tạo hồ sơ mới
```
GET /btl-web/applications/create
Response: Form HTML để tạo hồ sơ
```

```
POST /btl-web/applications/create
Content-Type: multipart/form-data

Body: FormData with files
- Thông tin cá nhân
- Nguyện vọng (majors)
- File upload (documents)
```

#### Xem hồ sơ của tôi
```
GET /btl-web/my-application
Response: Redirect tới /application/show nếu có hồ sơ
```

#### Chi tiết hồ sơ
```
GET /btl-web/application/show?id=1
Response: HTML chi tiết hồ sơ của student
```

### Thông tin ngành học
```
GET /btl-web/majors-info
Response: HTML danh sách ngành (public view)
```

### Kết quả tuyển sinh
```
GET /btl-web/admission-results
Response: HTML kết quả tuyển sinh của student
```

### Quản lý tài khoản

#### Thông tin cá nhân
```
GET /btl-web/profile
Response: Form HTML thông tin user
```

```
POST /btl-web/profile
Content-Type: application/x-www-form-urlencoded

Body:
name=New Name&email=new@email.com
```

#### Đổi mật khẩu
```
GET /btl-web/change-password
Response: Form HTML đổi password
```

```
POST /btl-web/change-password
Content-Type: application/x-www-form-urlencoded

Body:
current_password=old&new_password=new&confirm_password=new
```

---

## 🏠 Common Endpoints

### Homepage
```
GET /btl-web/
Response: Homepage HTML
```

### About
```
GET /btl-web/about
Response: About page HTML
```

### Dashboard
```
GET /btl-web/dashboard
Response: User dashboard (different UI cho Admin/Student)
```

---

## 📋 Sample Fetch Code cho Frontend

### Basic AJAX Call
```javascript
// GET request
async function fetchEndpoint(endpoint) {
    const response = await fetch(`http://localhost/btl-web${endpoint}`, {
        credentials: 'same-origin' // Important cho session
    });
    
    if (response.redirected) {
        // Có thể bị redirect tới login
        window.location.href = response.url;
        return;
    }
    
    return await response.text(); // HTML
}

// POST request
async function postData(endpoint, data) {
    const formData = new FormData();
    Object.keys(data).forEach(key => {
        formData.append(key, data[key]);
    });
    
    const response = await fetch(`http://localhost/btl-web${endpoint}`, {
        method: 'POST',
        body: formData,
        credentials: 'same-origin'
    });
    
    return response;
}
```

### Usage Examples
```javascript
// Login
await postData('/login', {
    email: 'admin@example.com',
    password: 'password'
});

// Load majors
const majorsHtml = await fetchEndpoint('/majors');
document.getElementById('content').innerHTML = majorsHtml;

// Create major (Admin only)
await postData('/majors/create', {
    code: 'CS01',
    name: 'Computer Science',
    description: 'CS Description'
});

// Load dashboard
const dashboardHtml = await fetchEndpoint('/dashboard');
```

---

## 🔒 Authentication & Sessions

### Session Management
- Backend sử dụng **PHP Sessions**
- Cookies được set tự động
- **Quan trọng**: Luôn dùng `credentials: 'same-origin'` trong fetch

### User Roles
```javascript
// Check user role từ dashboard response
const response = await fetch('/btl-web/dashboard');
const html = await response.text();

// Parse HTML để lấy thông tin user
if (html.includes('Admin Menu')) {
    // User là admin
    showAdminFeatures();
} else {
    // User là student
    showStudentFeatures();
}
```

### Error Handling
```javascript
async function handleResponse(response) {
    if (response.redirected && response.url.includes('login')) {
        // Session expired, cần login lại
        showLoginModal();
        return null;
    }
    
    if (!response.ok) {
        throw new Error(`HTTP ${response.status}`);
    }
    
    return await response.text();
}
```

---

## 🧪 Test Accounts

### Admin Account
```
Email: admin@example.com
Password: password
Role: Administrator
```

### Student Account
```
Email: student@example.com
Password: password
Role: Student
```

---

## 📊 Database Schema

### Users Table
```sql
- id (int, primary key)
- name (varchar)
- email (varchar, unique)
- password (varchar, hashed)
- is_admin (boolean)
- created_at, updated_at
```

### Majors Table
```sql
- id (int, primary key)
- code (varchar, unique) 
- name (varchar)
- description (text)
- created_at, updated_at
```

### Applications Table
```sql
- id (int, primary key)
- user_id (int, foreign key)
- status (enum: pending, processing, approved, rejected)
- created_at, updated_at
```

---

## 🚀 Quick Start cho Frontend

### 1. Test Backend Connection
```javascript
fetch('http://localhost/btl-web/backend_test.php')
  .then(response => response.text())
  .then(html => console.log('Backend Status:', html.includes('READY FOR FRONTEND')));
```

### 2. Test Authentication
```javascript
// Test login
fetch('http://localhost/btl-web/login', {
    method: 'POST',
    body: new URLSearchParams({
        email: 'admin@example.com',
        password: 'password'
    })
}).then(response => {
    console.log('Login Status:', response.status);
});
```

### 3. Test Endpoints
```javascript
const endpoints = [
    '/dashboard',
    '/majors', 
    '/applications/create',
    '/admin/applications'
];

endpoints.forEach(async (endpoint) => {
    const response = await fetch(`http://localhost/btl-web${endpoint}`);
    console.log(`${endpoint}: ${response.status}`);
});
```

---

## 🎯 Development Tips

### CORS Note
- Không cần CORS config vì cùng domain
- Chỉ cần `credentials: 'same-origin'`

### File Uploads
```javascript
// Upload files
const formData = new FormData();
formData.append('document', fileInput.files[0]);
formData.append('other_field', 'value');

fetch('/btl-web/applications/create', {
    method: 'POST',
    body: formData,
    credentials: 'same-origin'
});
```

### Error Debugging
- Check `http://localhost/btl-web/backend_test.php` cho system status
- Check browser Network tab cho HTTP errors
- Check Apache error logs nếu cần

---

## 📞 Support

**Backend Ready**: ✅ All 27 endpoints working  
**Database**: ✅ Connected with sample data  
**Authentication**: ✅ Session-based auth working  
**File Upload**: ✅ Configured and tested  

**Frontend team có thể bắt đầu ngay! 🚀** 