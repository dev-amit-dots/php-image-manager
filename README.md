<div align="center">

# 📸 PHP Image Manager

### A Production-Ready Image Upload, Optimization & Watermark Library Built with Core PHP

<p align="center">
  <img src="https://img.shields.io/badge/PHP-Core%20PHP-777BB4?style=for-the-badge&logo=php">
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql">
  <img src="https://img.shields.io/badge/GD-Library-orange?style=for-the-badge">
</p>

**A reusable image management library that provides secure uploads, image optimization, compression, resizing, and watermarking using pure Core PHP.**

---

</div>

# ✨ Overview

PHP Image Manager is a lightweight and reusable image processing library developed using **Core PHP** and the **GD Library**.

It is designed for developers who need a production-ready solution for handling image uploads while keeping storage usage low and protecting images with watermarks.

Unlike framework-specific packages, this project can be integrated into **any Core PHP application** without external dependencies.

---

# 🚀 Features

- ✅ Secure Image Upload
- ✅ Image Validation
- ✅ JPEG / PNG / WebP Support
- ✅ Automatic Image Optimization
- ✅ Smart Image Compression
- ✅ Image Resizing
- ✅ Transparent PNG Watermark
- ✅ Unique File Name Generation
- ✅ MySQL Integration
- ✅ Modular Architecture
- ✅ Reusable Helper Functions
- ✅ Production-Ready Code Structure
- ✅ Easy Integration into Existing Projects

---

# 🛠 Tech Stack

| Technology | Purpose |
|------------|---------|
| Core PHP | Backend |
| MySQL | Database |
| GD Library | Image Processing |
| HTML5 | Frontend |
| CSS3 | Styling |
| JavaScript | Optional UI Enhancements |

---

# 📂 Project Structure

```text
php-image-manager/

│

├── assets/
│   └── watermark/
│       └── logo.png
│
├── config/
│   ├── config.php
│   └── database.php
│
├── functions/
│   ├── helper.php
│   ├── validation.php
│   ├── upload.php
│   ├── image.php
│   └── watermark.php
│
├── uploads/
│   ├── optimized/
│   └── watermark/
│
├── index.php
├── upload_process.php
├── image.sql
└── README.md
```

---

# ⚙️ Workflow

```text
User Uploads Image
        │
        ▼
Validate Image
        │
        ▼
Generate Secure Filename
        │
        ▼
Resize Image (if required)
        │
        ▼
Optimize & Compress Image
        │
        ▼
Save Optimized Image
        │
        ▼
Apply Watermark
        │
        ▼
Save Watermarked Image
        │
        ▼
Store Metadata in MySQL
        │
        ▼
Success Response
```

---

# 📦 Installation

## 1. Clone the Repository

```bash
git clone https://github.com/dev-amit-dots/php-image-manager.git
```

---

## 2. Move the Project

Place the project inside your web server directory.

Example:

```
htdocs/
```

or

```
public_html/
```

---

## 3. Create Database

```sql
CREATE DATABASE image_manager;
```

Import

```
image.sql
```

---

## 4. Configure Database

Update

```
config/database.php
```

with your credentials.

```php
$host = "localhost";
$user = "root";
$password = "";
$db = "image_manager";
```

---

## 5. Add Watermark Logo

Place your transparent PNG logo inside

```
assets/watermark/logo.png
```

---

## 6. Start Uploading

Open

```
http://localhost/php-image-manager/
```

---

# 📁 Database Schema

| Column | Description |
|----------|-------------|
| id | Primary Key |
| image_name | Original Generated Name |
| optimized_image | Optimized Image Path |
| watermark_image | Watermarked Image Path |
| image_size | File Size |
| image_type | MIME Type |
| created_at | Upload Timestamp |

---

# 🔒 Security Features

- Allowed file type validation
- MIME type verification
- Maximum file size restriction
- Upload error handling
- Secure filename generation
- SQL Injection prevention
- Directory traversal protection
- Invalid image detection

---

# 📈 Image Processing Features

- Automatic compression
- Automatic optimization
- Aspect ratio maintained
- Resize oversized images
- Watermark support
- PNG transparency support
- JPEG optimization
- WebP support

---

# 🎯 Why This Project?

Many PHP projects simply upload images without optimizing or protecting them.

This library solves common problems by:

- Reducing storage usage
- Improving website performance
- Protecting images with watermarks
- Organizing uploaded files
- Providing reusable code for future projects

---

# 📌 Use Cases

- CRM Systems
- CMS Platforms
- E-commerce Websites
- Portfolio Websites
- Blog Systems
- Property Listing Platforms
- School Management Systems
- Gallery Applications
- Custom Admin Panels

---

# 🧩 Future Roadmap

- [ ] Drag & Drop Upload
- [ ] Multiple Image Upload
- [ ] AJAX Upload Support
- [ ] Image Cropping
- [ ] Image Rotation
- [ ] Thumbnail Generation
- [ ] EXIF Orientation Fix
- [ ] AVIF Support
- [ ] Bulk Watermark Processing
- [ ] REST API
- [ ] Amazon S3 Storage
- [ ] Cloudflare R2 Support
- [ ] Image Metadata Viewer

---

# 🤝 Contributing

Contributions are welcome.

If you have suggestions, bug fixes, or new features, feel free to:

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Open a Pull Request

---

# 📄 License

This project is licensed under the **MIT License**.

Feel free to use it in personal and commercial projects.

---

# 👨‍💻 Author

**Amit Tiwari**

Backend Developer | Core PHP | Laravel | Python | Django

GitHub: https://github.com/dev-amit-dots
GitHub: https://github.com/amittiwari-dev

LinkedIn: https://linkedin.com/in/amit-tiwari-2866-dev

---

<div align="center">

### ⭐ If you found this project helpful, consider giving it a star!

**Happy Coding! 🚀**

</div>
