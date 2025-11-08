# 🏥 Hospital Booking API

A Laravel-based backend API for managing doctor appointments, patient data, and hospital schedules — featuring iOS push notifications and secure authentication for a seamless healthcare booking experience.

---

## 📘 About the Project

**Hospital Booking API** is a backend system built using **Laravel**, designed to simplify the process of **doctor appointment booking** and **schedule management** in hospitals.  
It enables patients to book doctors easily, receive real-time updates through **APNs notifications**, and provides hospital staff with tools to manage availability and appointments efficiently.

This project focuses on delivering a **secure**, **scalable**, and **user-oriented** healthcare backend — making hospital services more accessible and efficient.

---

## ✨ Features

- 🩺 **Doctor Booking System** — Manage doctor schedules and patient appointments seamlessly.  
- 🔔 **Push Notifications (APNs)** — Real-time updates for appointment confirmations or schedule changes.  
- 🗓 **Schedule Management** — Doctors and admins can update and manage availability dynamically.  
- 🔐 **Authentication & Authorization** — Secure login and access control using **Laravel Sanctum**.  
- 🧾 **Patient Record Handling** — Store and retrieve patient booking data securely.  
- 📊 **Dashboard Ready** — Backend structured for easy integration with hospital admin dashboards.

---

## 🛠 Tech Stack

| Layer | Technology |
|-------|-------------|
| **Framework** | Laravel 11 |
| **Language** | PHP 8.3 |
| **Database** | MySQL |
| **Authentication** | Laravel Sanctum |
| **Notifications** | Apple Push Notification Service (APNs) |
| **Deployment** | Hostinger VPS + GitHub Actions |

---

## ⚙️ Installation

### 1️⃣ Clone Repository
```bash
git clone https://github.com/streynaldo/HospitalBookingAPI.git
cd hospital-booking-api
composer install
cp .env.example .env and update following keys
    APP_NAME="Hospital Booking API"
    DB_DATABASE=hospital_booking
    DB_USERNAME=root
    DB_PASSWORD=
php artisan migrate
php artisan serve


