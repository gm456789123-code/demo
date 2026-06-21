# ตลาดที่ดินไทย.com (made-wp)

เว็บไซต์ WordPress สำหรับแพลตฟอร์มประกาศและแนะนำที่ดินทั่วประเทศ

## รันโปรเจกต์ในเครื่อง (local dev)

โปรเจกต์นี้รันผ่าน PHP built-in server พร้อม router script ที่เขียนไว้ใน `router.php`
(ไม่ได้ใช้ XAMPP/Apache htdocs)

```
cd d:\web\made-wp
php -S localhost:8000 router.php
```

จากนั้นเปิด `http://localhost:8000/`

**สำคัญ:** ต้องสตาร์ทด้วย `router.php` เสมอ ห้ามรัน `php -S localhost:8000` เฉย ๆ
เพราะ PHP built-in server ไม่เติม `/` ปิดท้ายให้กับ URL ของโฟลเดอร์ (ต่างจาก Apache)
ทำให้ลิงก์ relative ใน wp-admin (เช่น `themes.php`) คำนวณ path ผิดแล้วเจอ 404
`router.php` แก้ปัญหานี้โดย redirect `/wp-admin` → `/wp-admin/` ให้อัตโนมัติ

### ฐานข้อมูล

- DB name: `data`
- DB user: `root` (ไม่มีรหัสผ่าน)
- DB host: `localhost`
- siteurl / home ใน DB ตั้งเป็น `http://localhost:8000` — ถ้าเปลี่ยนพอร์ตต้องอัปเดตค่านี้ใน `wp_options` ด้วย

## ธีม

ธีมหลักอยู่ที่ `wp-content/themes/talad-tidthai/` (classic PHP theme)

- `style.css` — theme header
- `functions.php` — enqueue Tailwind CSS (ผ่าน CDN), ฟอนต์ Noto Sans Thai, ตั้งค่าเมนู
- `header.php` / `footer.php` / `index.php` — โครงหน้าแรก ก็อปโครงสร้างมาจาก mockup `index.html` ที่ root

**สถานะปัจจุบัน:** เน้นให้หน้าตา (layout/markup) ตรงกับดีไซน์ก่อน เนื้อหายังเป็น static
(hardcode) ทั้งหมด ยังไม่ได้ผูกกับข้อมูลจริงใน WordPress (custom post type, ACF ฯลฯ)
และยังไม่ได้ตั้งเป็นธีมที่ active ใน wp-admin (ปัจจุบัน active theme คือ `twentytwentyfive`)

## ไฟล์ที่เกี่ยวข้อง

- `index.html` — static mockup ของหน้าแรก (Tailwind CDN) ใช้เป็นต้นแบบก่อนแปลงเป็นธีมจริง
- `router.php` — router สำหรับ PHP built-in server (ดูด้านบน)
