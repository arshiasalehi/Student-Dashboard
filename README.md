# Student Dashboard

Simple PHP MVC app that provides secure student registration/login and a customizable dashboard.

## Features
- Registration and login with server-side validation and hashed passwords
- CSRF protection, prepared statements, session hardening (idle timeout, fixation protection)
- Student dashboard with persistent preferences (text size, color scheme, notifications) stored in cookies
- Session-based page view counter and preference summary

## Tech Stack
- PHP 8+ (built-in server for local dev)
- MySQL (PDO)
- Vanilla PHP views (no framework)

## Setup
1) Install PHP and MySQL locally.  
2) Create the database/schema:
```sh
mysql -u root -p < database.sql
```
3) Update `config.php` with your DB credentials.  
4) Run locally from the project root:
```sh
php -S localhost:8000
```
Visit `http://localhost:8000/index.php?route=register` to create an account, then log in.

## VS Code SQLTools
Preconfigured connection in `.vscode/settings.json` for the local MySQL database (`student_dashboard`).
