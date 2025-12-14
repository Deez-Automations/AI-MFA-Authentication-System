# 🔐 AI-MFA Authentication System

A comprehensive **Multi-Factor Authentication (MFA)** system featuring AI-powered face recognition, OTP email verification, and secure password hashing. Built with PHP, PostgreSQL, and TensorFlow.js.

![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=flat-square&logo=php&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-13+-336791?style=flat-square&logo=postgresql&logoColor=white)
![TensorFlow.js](https://img.shields.io/badge/TensorFlow.js-BlazeFace-FF6F00?style=flat-square&logo=tensorflow&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

---

## 📋 Table of Contents

- [Features](#-features)
- [Architecture](#-architecture)
- [Prerequisites](#-prerequisites)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Database Setup](#-database-setup)
- [Usage](#-usage)
- [Security Features](#-security-features)
- [Project Structure](#-project-structure)
- [API Endpoints](#-api-endpoints)
- [Contributing](#-contributing)
- [License](#-license)

---

## ✨ Features

### 🔑 Multi-Factor Authentication
- **Face Recognition Login** - AI-powered facial verification using TensorFlow.js BlazeFace model
- **Email OTP Verification** - One-time password sent via EmailJS during registration
- **Secure Password Authentication** - Salt and pepper hashing with bcrypt

### 🛡️ Security Highlights
- Environment-based credential management (no hardcoded secrets)
- Password hashing with unique salt per user + server-side pepper
- Session-based authentication with CSRF protection
- Production-safe error handling (no debug info leakage)

### 🎨 Modern UI
- Responsive design with glassmorphism effects
- Smooth animations and transitions
- Dark theme with gradient accents
- Mobile-friendly interface

---

## 🏗️ Architecture

```
┌─────────────────┐     ┌─────────────────┐     ┌─────────────────┐
│                 │     │                 │     │                 │
│  Frontend       │────▶│  PHP Backend    │────▶│  PostgreSQL     │
│  (HTML/JS/CSS)  │     │  (PDO/API)      │     │  Database       │
│                 │     │                 │     │                 │
└─────────────────┘     └─────────────────┘     └─────────────────┘
        │                       │
        │                       │
        ▼                       ▼
┌─────────────────┐     ┌─────────────────┐
│  TensorFlow.js  │     │  EmailJS        │
│  (Face Detection)│    │  (OTP Service)  │
└─────────────────┘     └─────────────────┘
```

---

## 📦 Prerequisites

Before installation, ensure you have:

| Requirement | Version | Purpose |
|-------------|---------|---------|
| PHP | 8.0+ | Backend runtime |
| PostgreSQL | 13+ | Database |
| XAMPP/WAMP/MAMP | Latest | Local development server |
| Web Browser | Chrome/Firefox/Edge | Camera access for face detection |
| EmailJS Account | Free tier | OTP email delivery |

---

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/Deez-Automations/AI-MFA-Authentication-System.git
cd AI-MFA-Authentication-System
```

### 2. Create Environment File

```bash
# Copy the example environment file
cp .env.example .env

# Edit with your credentials
notepad .env  # Windows
nano .env     # Linux/Mac
```

### 3. Configure Environment Variables

Edit `.env` with your settings:

```ini
# Database Configuration
DB_HOST=localhost
DB_NAME=authentication_system
DB_USER=postgres
DB_PASS=your_secure_password

# Security (generate with: openssl rand -hex 32)
SECURITY_PEPPER=your_32_character_random_string

# EmailJS Configuration
EMAILJS_PUBLIC_KEY=your_emailjs_public_key
EMAILJS_SERVICE_ID_GMAIL=your_service_id
EMAILJS_TEMPLATE_ID=your_template_id

# Application Settings
APP_ENV=development
APP_DEBUG=true
```

### 4. Start Your Web Server

**Using XAMPP:**
1. Copy project folder to `C:\xampp\htdocs\`
2. Start Apache from XAMPP Control Panel
3. Access at `http://localhost/AI-MFA-Authentication-System/`

**Using PHP Built-in Server:**
```bash
php -S localhost:8000
```

---

## ⚙️ Configuration

### Environment Variables

| Variable | Description | Required |
|----------|-------------|----------|
| `DB_HOST` | PostgreSQL host address | ✅ |
| `DB_NAME` | Database name | ✅ |
| `DB_USER` | Database username | ✅ |
| `DB_PASS` | Database password | ✅ |
| `SECURITY_PEPPER` | Secret pepper for password hashing | ✅ |
| `EMAILJS_PUBLIC_KEY` | EmailJS public key | ✅ |
| `APP_DEBUG` | Enable debug mode (true/false) | ❌ |

### EmailJS Setup

1. Create account at [emailjs.com](https://www.emailjs.com)
2. Create an Email Service (connect Gmail/Outlook)
3. Create an Email Template with variables: `{{email}}`, `{{passcode}}`, `{{time}}`
4. Copy Service ID, Template ID, and Public Key to `.env`

---

## 🗃️ Database Setup

### 1. Create Database

```sql
CREATE DATABASE authentication_system;
```

### 2. Run Schema

Execute the `database.sql` file in PostgreSQL:

```bash
psql -U postgres -d authentication_system -f database.sql
```

Or use pgAdmin to run the SQL file.

### Database Schema

| Table | Description |
|-------|-------------|
| `users` | User profiles (name, email, phone, DOB) |
| `passwords` | Password hashes with salt, pepper, and key |
| `face_auth` | Face recognition data for each user |

---

## 📖 Usage

### Registration Flow

1. Navigate to `registration.html`
2. Fill in personal details
3. Create strong password (8+ chars, uppercase, number, special char)
4. Optionally enable Face ID setup
5. Verify email with OTP code
6. Complete face setup (if enabled)

### Login Flow

**Option A: Password Login**
1. Enter email and password
2. Redirect to dashboard on success

**Option B: Face ID Login**
1. Click "Use Face ID" button
2. Allow camera access
3. Position face in frame
4. Automatic verification and login

---

## 🔒 Security Features

### Password Security

```
User Password → Salt (random) + Pepper (server secret) → SHA-256 Key → bcrypt Hash
```

- **Salt**: 32-character random string (unique per user)
- **Pepper**: Server-side secret stored in environment variables
- **Key**: Intermediate hash for additional security layer
- **Hash**: Final bcrypt hash stored in database

### Session Protection

- Server-side session management
- CSRF token validation
- Secure logout with session destruction
- No sensitive data in client storage

### Face Recognition

- Uses TensorFlow.js BlazeFace model
- Client-side face detection (no images sent to server)
- Euclidean distance matching with configurable threshold
- Face data stored as numerical vectors

---

## 📁 Project Structure

```
AI-MFA-Authentication-System/
│
├── 📄 Configuration
│   ├── .env.example          # Environment template
│   ├── .gitignore            # Git ignore rules
│   ├── config.php            # Configuration loader
│   └── database.sql          # Database schema
│
├── 📄 PHP Backend
│   ├── db.php                # Database connection
│   ├── login.php             # Password/Face login handler
│   ├── register.php          # User registration
│   ├── face.php              # Face data storage
│   ├── face_login.php        # Face authentication
│   ├── otp.php               # OTP verification
│   ├── session.php           # Session middleware
│   └── logout.php            # Session termination
│
├── 📄 HTML Pages
│   ├── index.html            # Landing page
│   ├── login.html            # Login page
│   ├── registration.html     # Registration page
│   ├── verify-otp.html       # OTP verification
│   ├── face-setup.html       # Face ID setup
│   └── dashboard.html        # User dashboard
│
├── 📁 js/                    # JavaScript modules
│   ├── auth.js               # Authentication class
│   ├── login.js              # Login functionality
│   ├── registration.js       # Registration logic
│   ├── face-recognition.js   # Face detection
│   ├── otp.js                # OTP handling
│   └── utils.js              # Utility functions
│
└── 📁 css/                   # Stylesheets
    ├── styles.css            # Global styles
    ├── auth.css              # Auth form styles
    ├── login.css             # Login page
    ├── registration.css      # Registration page
    └── dashboard.css         # Dashboard styles
```

---

## 🔌 API Endpoints

### Authentication

| Endpoint | Method | Description |
|----------|--------|-------------|
| `login.php` | POST | Password and face login |
| `register.php` | POST | User registration |
| `logout.php` | GET | Session termination |

### Face Authentication

| Endpoint | Method | Description |
|----------|--------|-------------|
| `face.php` | POST | Save face data |
| `face_login.php` | POST | Verify face data |

### OTP Verification

| Endpoint | Method | Description |
|----------|--------|-------------|
| `otp.php` | POST | Verify OTP code |

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 👤 Author

**Deez Automations**

- GitHub: [@Deez-Automations](https://github.com/Deez-Automations)
- Email: work.deezlabs@gmail.com

---

## 🙏 Acknowledgments

- [TensorFlow.js](https://www.tensorflow.org/js) - Face detection model
- [BlazeFace](https://github.com/nicholascelestin/BlazeFace) - Real-time face detection
- [EmailJS](https://www.emailjs.com) - Email delivery service
- [PostgreSQL](https://www.postgresql.org) - Database management

---

<p align="center">
  Made with ❤️ by Deez Automations
</p>
