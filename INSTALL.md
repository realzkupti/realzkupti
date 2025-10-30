# คู่มือการติดตั้ง TailAdmin Template

คู่มือการติดตั้งโดยละเอียดสำหรับ TailAdmin Template (ภาษาไทย)

## ความต้องการของระบบ

- PHP >= 8.1
- Composer
- ฐานข้อมูล (MySQL, PostgreSQL, SQLite, หรือ SQL Server)
- Web Server (Apache, Nginx, หรือ PHP Built-in Server)

## ขั้นตอนการติดตั้ง

### 1. Clone หรือ Download โปรเจกต์

```bash
git clone <your-repo-url>
cd TailAdminTemplate
```

### 2. ติดตั้ง Dependencies ด้วย Composer

```bash
composer install
```

หากยังไม่มี Composer ให้ดาวน์โหลดได้ที่: https://getcomposer.org/

### 3. สร้างไฟล์ .env

คัดลอกไฟล์ `.env.example` เป็น `.env`:

```bash
cp .env.example .env
```

หรือบน Windows:
```cmd
copy .env.example .env
```

### 4. ตั้งค่าฐานข้อมูล

เปิดไฟล์ `.env` และแก้ไขการตั้งค่าฐานข้อมูลตามที่คุณใช้:

#### สำหรับ MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tailadmin
DB_USERNAME=root
DB_PASSWORD=
```

#### สำหรับ PostgreSQL:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=tailadmin
DB_USERNAME=postgres
DB_PASSWORD=
```

#### สำหรับ SQLite:

```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

สร้างไฟล์ SQLite:
```bash
touch database/database.sqlite
```

#### สำหรับ SQL Server:

```env
DB_CONNECTION=sqlsrv
DB_HOST=127.0.0.1
DB_PORT=1433
DB_DATABASE=tailadmin
DB_USERNAME=sa
DB_PASSWORD=
```

### 5. สร้าง Application Key

```bash
php artisan key:generate
```

คำสั่งนี้จะสร้าง key สำหรับการเข้ารหัสข้อมูล

### 6. รัน Migrations

สร้างตารางในฐานข้อมูล:

```bash
php artisan migrate
```

### 7. ตั้งค่า Permissions (สำหรับ Linux/Mac)

```bash
chmod -R 775 storage bootstrap/cache
```

### 8. เริ่มใช้งาน Development Server

```bash
php artisan serve
```

เปิดเบราว์เซอร์และเข้าไปที่: `http://localhost:8000`

## การติดตั้งบน Production Server

### สำหรับ Apache

1. ตั้งค่า Document Root ไปที่โฟลเดอร์ `public`
2. ตรวจสอบว่า mod_rewrite เปิดใช้งาน
3. ไฟล์ `.htaccess` อยู่ในโฟลเดอร์ `public` แล้ว

### สำหรับ Nginx

เพิ่ม configuration นี้:

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/TailAdminTemplate/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## การใช้งานเบื้องต้น

### 1. สร้างผู้ใช้แรก

เปิดเบราว์เซอร์และไปที่: `http://localhost:8000/register`

กรอกข้อมูล:
- ชื่อ-นามสกุล
- อีเมล
- รหัสผ่าน (อย่างน้อย 6 ตัวอักษร)
- ยืนยันรหัสผ่าน

### 2. เข้าสู่ระบบ

หลังจากสมัครสำเร็จ คุณจะถูกนำไปยังหน้า Dashboard อัตโนมัติ

หรือเข้าสู่ระบบด้วยตนเองที่: `http://localhost:8000/login`

### 3. ทดสอบระบบ

- ทดสอบการ Login/Logout
- ทดสอบการอัปเดต Profile
- เปิด Developer Tools (F12) และดูที่ Network tab เพื่อดู AJAX requests

## การแก้ปัญหา

### ปัญหา: "CSRF token mismatch"

**แก้ไข**:
1. ล้าง cache: `php artisan cache:clear`
2. ล้าง config: `php artisan config:clear`
3. ตรวจสอบว่ามี `<meta name="csrf-token">` ใน layout

### ปัญหา: "Class not found"

**แก้ไข**:
```bash
composer dump-autoload
```

### ปัญหา: "Permission denied" (Linux/Mac)

**แก้ไข**:
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### ปัญหา: "Database connection error"

**แก้ไข**:
1. ตรวจสอบการตั้งค่าใน `.env`
2. ตรวจสอบว่าฐานข้อมูลทำงาน
3. ตรวจสอบ username และ password

### ปัญหา: "500 Internal Server Error"

**แก้ไข**:
1. เปิดดู logs: `storage/logs/laravel.log`
2. ตรวจสอบ APP_DEBUG=true ในไฟล์ `.env`
3. ตรวจสอบ permissions ของโฟลเดอร์ storage

## คำแนะนำเพิ่มเติม

### การเปลี่ยน Database ระหว่างการใช้งาน

1. แก้ไขค่า `DB_CONNECTION` ใน `.env`
2. ตั้งค่าการเชื่อมต่อฐานข้อมูลใหม่
3. รัน migrations: `php artisan migrate:fresh`

### การ Backup ฐานข้อมูล

#### MySQL:
```bash
mysqldump -u root -p tailadmin > backup.sql
```

#### PostgreSQL:
```bash
pg_dump tailadmin > backup.sql
```

#### SQLite:
```bash
cp database/database.sqlite database/database.sqlite.backup
```

### การปรับแต่งระบบ

- แก้ไข CSS: `public/assets/css/tailadmin.css`
- แก้ไข JavaScript: `public/assets/js/auth.js`
- เพิ่ม Controllers: `app/Http/Controllers/`
- เพิ่ม Views: `resources/views/`
- เพิ่ม Routes: `routes/web.php` และ `routes/api.php`

## ข้อมูลเพิ่มเติม

- [Laravel Documentation](https://laravel.com/docs)
- [PHP Documentation](https://www.php.net/docs.php)
- [Composer Documentation](https://getcomposer.org/doc/)

## การติดต่อและรายงานปัญหา

หากพบปัญหาหรือมีคำถาม กรุณาสร้าง issue บน GitHub

---

**สร้างด้วย ❤️ โดยใช้ Laravel และ TailAdmin**
