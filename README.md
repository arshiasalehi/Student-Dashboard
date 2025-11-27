# 🎓 Student Dashboard

**Student Dashboard** is a lightweight PHP MVC application that provides secure student registration, login, and a fully personalized dashboard experience.  
It features strong backend validation, session hardening, CSRF protection, preference persistence using cookies, and clean separation of concerns through a custom MVC structure.

Built with **PHP**, **MySQL**, and **vanilla MVC architecture**, this project is ideal for learning backend security, PHP routing, and MVC patterns.

---

## 🚀 Features

### 🔐 Authentication & Security
- Secure registration and login  
- Password hashing (`password_hash()`)  
- CSRF tokens on sensitive forms  
- Prepared statements  
- Session hardening (ID regeneration, fixation protection, idle timeout)

### 🏠 Student Dashboard
- Customizable student dashboard  
- Persistent preferences stored in cookies:
  - Text size  
  - Color scheme  
  - Notifications toggle  
- Session-based page view counter  
- Preference summary box  

### 🧱 MVC Architecture
- Models → data + queries  
- Controllers → routing + form handling  
- Views → clean PHP templates  
- `index.php` → front controller + router  

---

# 💻 Tech Stack

## 🖥️ Backend
PHP 8+, MySQL (PDO), MVC (no framework)

## 🧰 Dev Tools
VS Code, SQLTools, PHP built-in server

---

# 🧠 Architecture Overview

## 🎨 Presentation Layer (Views)
- `views/register.php`  
- `views/login.php`  
- `views/dashboard.php`  

## 🚦 Controllers
- `RegisterController.php`  
- `LoginController.php`  
- `DashboardController.php`  

## 🗄️ Models
- `User.php`  
- `Auth.php` (validation + sessions + CSRF)  

## ⚙️ Core System
- `index.php` — main router  
- `config.php` — DB config  
- `lib/CSRF.php` — token utilities  
- `lib/Session.php` — hardening rules  

---

# 🛠️ Setup Instructions

1. **Install PHP & MySQL**

2. **Create the database + schema**
3. **Configure your database credentials**

In `config.php`:
4. **Run the PHP development server**
5. **Access the app**

👉 http://localhost:8000/index.php?route=register

---

# 📊 Project Stats

| Metric               | Value                       |
|----------------------|-----------------------------|
| Main Language        | PHP                         |
| Database             | MySQL (PDO)                 |
| Architecture         | Custom MVC                  |
| Development Time     | ~1–2 days                   |

---

# 📚 Top Languages Used

PHP (90%)  
SQL (10%)

---

# 👥 Author

- **Arshia Salehi** — https://github.com/arshiasalehi
