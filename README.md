# MedSchedule | Online Doctor Appointment System

MedSchedule is a responsive, web-based doctor appointment management system developed as a **Design Engineering** project. It is designed to digitize the traditional clinic scheduling workflow, allowing patients to easily find doctors, select convenient slots, and book appointments without standing in long waiting queues.

---

## 🚀 Key Features

*   **Responsive Landing Page:** Modern hero section, dynamic facilities cards, about section, and interactive team developer links.
*   **Secure Authentication:** Secure User Registration and Login with password hashing (`password_hash`) and robust validation rules (minimum 6 characters, at least 1 uppercase letter, 1 number, and 1 special character).
*   **SQL Injection Protection:** Database queries use prepared statements (`prepare` and `bind_param`) to prevent security vulnerabilities.
*   **Doctor Discovery:** Seamless search and filter options to browse doctors by specialization and availability.
*   **Easy Scheduling:** Simple 3-step scheduling process (Find Doctor ➜ Select Date/Time ➜ Confirm Appointment).
*   **Personal Dashboard:** View upcoming appointments, cancel visits, and manage patient profiles (including profile photo updates).

---

## 🛠️ Technologies Used

*   **Frontend:** HTML5, CSS3 (Glassmorphism & modern transitions), JavaScript
*   **Backend:** PHP (Session-based auth, secure validation, prepared statements)
*   **Database:** MySQL (Structured relational design)

---

## 📁 Repository Structure

```text
├── README.md                  # Main project documentation (this file)
├── .gitignore                 # Standard file exclusions for version control
└── de_project                 # Core project codebase
    ├── DataBase               # Database seeding
    │   └── medschedule.sql    # Complete SQL database dump (structure + data)
    ├── ScreenShots            # Application previews & UI screenshots
    │   ├── heroM.png
    │   ├── loginM.png
    │   ├── registerM.png
    │   ├── homeM.png
    │   ├── DoctorM.png
    │   ├── BookM.png
    │   ├── UpcomingM.png
    │   └── ProfileM.png
    ├── UI                     # Complete styled user interface and system logic
    │   ├── css                # Style sheets
    │   │   ├── style.css      # Core styles (landing page, register, login)
    │   │   └── dashboard.css  # Dashboard / home panel styles
    │   ├── includes           # Reusable templates
    │   │   └── navbar.php     # Dynamic top navigation header
    │   ├── appointments.php   # Appointment booking handler
    │   ├── cancel.php         # Cancel appointment logic
    │   ├── doctors.php        # Doctor list & search
    │   ├── home.php           # User landing panel (home dashboard)
    │   ├── index.php          # Main homepage landing
    │   ├── login.php          # Secure login form & processing
    │   ├── logout.php         # Session destroyer
    │   ├── profile.php        # View & modify user profile and picture
    │   ├── register.php       # Secure account creation portal
    │   └── upcoming.php       # List of scheduled appointments
    └── db.php                 # Global database connection controller
```

---

## ⚙️ Installation & Setup Instructions

Follow these simple steps to run the project locally on your machine:

### 1. Prerequisites
*   Install a local server environment such as [XAMPP](https://www.apachefriends.org/) or [WampServer](http://www.wampserver.com/) (which contains PHP and MySQL).
*   Ensure **Git** is installed if cloning directly from a repository.

### 2. Set Up Database
1.  Start **Apache** and **MySQL** services in your XAMPP Control Panel.
2.  Open your browser and navigate to `http://localhost/phpmyadmin`.
3.  Create a new database named **`medschedule`**.
4.  Select the `medschedule` database, click on the **Import** tab.
5.  Choose the SQL file located at: `/de_project/DataBase/medschedule.sql` and click **Import** (or **Go**).

### 3. Deploy Project Files
1.  Copy the entire `doctor-appointment-system-main` project directory.
2.  Paste it inside the `htdocs` directory of your XAMPP installation:
    *   *Windows default path:* `C:\xampp\htdocs\doctor-appointment-system-main`

### 4. Run the Application
1.  Open your web browser.
2.  Navigate to: `http://localhost/doctor-appointment-system-main/de_project/UI/index.php`
3.  Explore the landing page, register a new account, login, and test booking appointments!

---

## 👥 Meet The Team

This application was developed as a Design Engineering project by:

*   **Bansari Vaishnav** - [LinkedIn Profile](https://www.linkedin.com/in/bansari-vaishnav-8575a1318)
*   **Smeet Vaghela** - [LinkedIn Profile](https://www.linkedin.com/in/smeet-vaghela-601a1b287)
*   **Radha Patil** - [LinkedIn Profile](https://www.linkedin.com/in/radha-patil-842057397)
*   **Netra Patel** - [LinkedIn Profile](https://www.linkedin.com/in/netra-patel-734169315)
*   **Rakshita Rathod**
