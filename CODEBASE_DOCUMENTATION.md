# Exhaustive Codebase Documentation: Leave Manager System

This document provides a detailed overview of **EVERY single file** in the Leave Manager project, explaining its purpose, contents, and how to modify it.

---

## 📁 1. Core Logic & Configuration

| File Name | What it Does | Modification Tips |
| :--- | :--- | :--- |
| `connection.php` | Primary MySQL database connection file. | Update DB credentials here if server settings change. |
| `db.php` | Database schema initialization script. Auto-creates tables. | Add new SQL table definitions here for expansion. |
| `functions.php` | Global repository for shared PHP functions. | Add reusable helper functions here to stay DRY. |
| `process.php` | central processing engine for all form data. | Modify this to change the logic behind any button action. |
| `config.xml` | Configuration settings for the application environment. | Check this for environment-specific variables. |
| `build.xml` | Ant/Build configuration for automation. | Rarely modified unless using build pipelines. |
| `phpunit.xml.dist` | Configuration for the PHPUnit testing framework. | Update if you add new test directories. |

---

## 🔑 2. Authentication & User Management

| File Name | What it Does | Modification Tips |
| :--- | :--- | :--- |
| `index.php` | Entry point. Redirects users based on session. | Modify landing logic or default redirect path. |
| `login.php` | User login interface for Staff and Supervisors. | Update this to change the login UI or security. |
| `register.php` | Public registration page for new staff members. | Add or remove fields to change registration data. |
| `inc.register.php` | Included logic for the registration workflow. | Modify validation or hashing logic for new accounts. |
| `logout.php` | Terminates sessions and redirects to landing. | Standard file; usually does not require modification. |
| `recover.php` | Interface for password recovery initiation. | Customize the email format or security tokens here. |
| `account.php` | User profile management page. | Update this to allow editing more personal info. |
| `members.php` | Displays a list of system members/users. | Modify SQL to change how users are filtered. |
| `user.php` | Detailed view of an individual user record. | Change how user metadata is presented visually. |

---

## 📊 3. Dashboards & Primary Modules

| File Name | What it Does | Modification Tips |
| :--- | :--- | :--- |
| `dashboard.php` | Main workspace for Staff/Supervisors. Tabbed UI. | Add new feature tabs for employees or managers. |
| `admin.php` | Master control panel for Administrators. | Modify the sidebar to add new admin tools. |
| `tutor.php` | Specialized view for users with the tutor role. | Customize specifically for tutor functionalities. |
| `about.php` | "About Us" page for the system. | Update the text or project background info here. |
| `stats.php` | Module for displaying leave statistics. | Add new charts or data points to the stats view. |
| `404.php` | Custom error page for missing resources. | Update UI or buttons for better error handling UX. |
| `thankyou.php` | Success confirmation page after key actions. | Customize final messages or follow-up instructions. |
| `sitemap.php` | Sitemap of the application pages. | Update this as you add more pages to the project. |

---

## 🗓️ 4. Leave Management & Approval Flow

| File Name | What it Does | Modification Tips |
| :--- | :--- | :--- |
| `leaves.php` | Overview of all leave records. | Modify the table columns or filtering logic here. |
| `leave-types.php` | Definitions of supported leave categories. | Add new leave types (e.g. "Sabbatical") here. |
| `leave-meta.php` | Metadata for leave constraints and limits. | Adjust balance calculation logic or day limits. |
| `new-request.php` | Form for submitting new leave applications. | Change the form layout or add new required fields. |
| `request.php` | Viewing details of a specific leave request. | Change how a single request is presented. |
| `pending.php` | Aggregate view for all pending items. | Update logic to show different types of pending tasks. |
| `pending-leaves.php` | Requests awaiting Supervisor/Admin action. | Modify how items are listed for managers. |
| `recommend.php` | Interface for Supervisor recommendations. | Update recommendation fields or validation rules. |
| `approve.php` | Final Admin approval module. | Modify final decision logic or email alerts. |
| `assign.php` | Logic for assigning staff to supervisors. | Modify reporting hierarchy UI or DB logic. |
| `update.php` | Script for updating existing database records. | Handle metadata or leave status updates here. |
| `delete.php` | Script for deleting database entities. | **Caution**: Be careful with data deletion logic. |
| `desc.php` | Logic for displaying detailed descriptions. | Change how descriptions are formatted for the UI. |
| `new.php` | Generic interface for creating new entities. | Use as template for adding new system modules. |

---

## 🎨 5. UI Assets & Site Infrastructure

| File Name | What it Does | Modification Tips |
| :--- | :--- | :--- |
| `header.php` | Reusable top section and navigation bar. | Change site logo or navigation links here. |
| `footer.php` | Reusable bottom section with copyright. | Update copyright or footer info links here. |
| `dash-header.php` | Dashboard-specific navigation header. | Customize user profile dropdown or menu. |
| `styles.php` | Loads CSS stylesheets into the site. | Include new CSS libraries or local styles here. |
| `scripts.php` | Loads JavaScript files into the pages. | Include new JS plugins or scripts here. |
| `test.php` | Playground file for testing code. | Safe to use for experiments or to delete. |

---

## 📁 6. Other Project Files

- `README.md`: Setup instructions and project overview.
- `generate_proposal.py`: Script to generate a project proposal.
- `create_docs_docx.py`: Automation script used to generate documentation.
- `Complete_Codebase_Documentation.docx`: Exhaustive guide in Word format.
- `Project_Proposal_Leave_Manager.docx`: Auto-generated proposal document.

---

## 📂 7. Subdirectories

- `bootstrap/`: Bootstrap framework files.
- `css/`: Custom stylesheets.
- `db/`: SQL schema and database files.
- `fonts/`: Iconography and web fonts.
- `imgs/`: UI images and graphic assets.
- `js/`: Custom JavaScript scripts.
