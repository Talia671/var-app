<p align="center">
  <img src="public/assets/images/logo-pkt.svg" width="280">
</p>

<h1 align="center">VAR APP</h1>

<p align="center">
  Vehicle Access Request System
</p>

<p align="center">
  <b>Modern Vehicle Access & Inspection Management Platform</b>
</p>

---

### 📋 PROJECT OVERVIEW

**VAR APP** is a comprehensive vehicle access management system designed for industrial environments. The platform streamlines the process of requesting and inspecting vehicle access permissions, ensuring that all operational vehicles meet the required safety and documentation standards.

The system manages the following core modules:

-   **SIMPER**: Surat Izin Mengemudi Perusahaan (Company Driver's License)
-   **UJSIMP**: Uji SIMP (Driver's Competency Testing)
-   **CHECKUP**: Vehicle Physical Inspection
-   **RANMOR**: Motorized Vehicle Inspection

The application provides a robust ecosystem for:

-   📄 **Digital Inspection Documentation**
-   ⚙️ **Automated Approval Workflows**
-   🔐 **Role-Based Access Control (RBAC)**
-   📋 **Centralized Inspection Template System**

---

### ✨ CORE FEATURES

-   🏗️ **Modular Inspection System** - Specialized modules for different inspection types.
-   🛡️ **Role Based Access Control** - Secure access management for Admin, Petugas, and Viewer.
-   🔄 **Document Approval Workflow** - Multi-stage approval process with status tracking.
-   📂 **Digital Inspection Records** - Paperless storage and management of all inspection data.
-   🛠️ **Unified Inspection Template System** - Standardized templates for consistent data entry.
-   🎨 **Modern UI Design System** - Professional and intuitive user interface based on the VAR APP design system.

---

### 👥 SYSTEM ROLES

| Role        | Description                                               |
| :---------- | :-------------------------------------------------------- |
| **Admin**   | Document approval, system monitoring, and PDF generation. |
| **Petugas** | Data entry, inspection input, and draft submission.       |
| **Viewer**  | View document history and personal application status.    |

---

### 🏗️ PROJECT ARCHITECTURE

The project follows a clean and modular Laravel architecture:

```text
app/
├── Http/
│   └── Controllers/   # Business logic (Admin, Petugas, Viewer)
├── Models/            # Database entities (Simper, Checkup, Ranmor, Ujsimp)
database/
├── migrations/        # Database schema definitions
└── seeders/           # Initial demo data (Users, Templates, etc.)
resources/
├── views/             # Blade templates (Admin, Petugas, Viewer layouts)
└── css/               # Tailwind CSS and Design System styles
routes/                # Web routing with Role-based middleware
public/                # Static assets (logos, images, compiled assets)
```

**Key Components:**

-   **Controllers**: Handle request logic and route to appropriate services.
-   **Models**: Represent data structures and relationships for each module.
-   **Views**: Modern Blade templates with Tailwind CSS and AlpineJS.
-   **Seeders**: Automated population of demo accounts and system templates.

---

### 🔑 DEMO ACCOUNTS

Use the following seeded accounts for testing and development purposes.

| Role        | Email              | Password   | Description                   |
| :---------- | :----------------- | :--------- | :---------------------------- |
| **Admin**   | `admin@var.com`    | `password` | Full system access & approval |
| **Petugas** | `petugas1@var.com` | `password` | Data entry & inspection input |
| **Viewer**  | `budi@var.com`     | `password` | Read-only history access      |

> [!NOTE]
> The default password for all demo accounts is **`password`**.

---

### 🚀 INSTALLATION GUIDE

Follow these steps to set up the project locally.

#### STEP 1 — CLONE PROJECT

```bash
git clone <repository-url>
cd var-app
```

#### STEP 2 — INSTALL DEPENDENCIES

```bash
composer install
npm install
```

#### STEP 3 — ENVIRONMENT CONFIGURATION

```bash
cp .env.example .env
```

_Configure your database credentials inside the `.env` file._

#### STEP 4 — GENERATE APPLICATION KEY

```bash
php artisan key:generate
```

---

### 🗄️ DATABASE SETUP

Choose one of the following seeding options based on your needs.

#### OPTION A — RUN ONLY ACCOUNT SEEDER

This will create only the demo user accounts listed above.

```bash
php artisan migrate
php artisan db:seed --class=UserSeeder
```

#### OPTION B — RUN FULL SEEDER

This will populate the entire system with comprehensive demo data.

```bash
php artisan migrate:fresh --seed
```

_This option includes:_

-   ✅ Demo accounts
-   ✅ Inspection templates
-   ✅ Sample inspection documents

---

### 🏃 RUNNING THE APPLICATION

To start the development environment, run both commands in separate terminals:

**Terminal 1 (Laravel Server):**

```bash
php artisan serve
```

**Terminal 2 (Vite Server):**

```bash
npm run dev
```

---

### 🌐 ACCESS THE APPLICATION

Once the servers are running, access the application at:

[**http://127.0.0.1:8000**](http://127.0.0.1:8000)

---

### 🛠️ TECHNOLOGY STACK

-   **Framework**: Laravel 12
-   **Frontend**: Tailwind CSS & AlpineJS
-   **Build Tool**: Vite
-   **Database**: MySQL
-   **PDF Engine**: Barryvdh DomPDF

---

### 📝 DEVELOPMENT NOTES

-   **Role Middleware**: Access control is enforced via `role:admin`, `role:petugas`, and `role:viewer` middlewares.
-   **PDF Generation**: Document export functionality is powered by the DomPDF library for high-quality reports.
-   **Inspection Template System**: A centralized system allows for easy modification of inspection criteria across all modules.

---

### 👨‍💻 PROJECT AUTHOR

| Field            | Detail                                          |
| :--------------- | :---------------------------------------------- |
| **Student Name** | Nur Taliyah                                     |
| **NIM**          | 202312030                                       |
| **Institution**  | **STITEK** (Sekolah Tinggi Teknologi)           |
| **Project Goal** | Digitalization of Vehicle Access Request System |

---

<p align="center">
  <b>VAR APP — Vehicle Access Request System</b>
</p>
