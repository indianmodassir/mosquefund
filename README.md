# Mosque Fund Collection

A simple online platform for house-to-house collection of mosque monthly donations and secure submission/management of collected funds.

## What is this

“Mosque Fund Collection” provides:

- Digital tracking of donations collected by authorized field-collectors.  
- Submission and logging of collected amounts.  
- A central interface to monitor donation collection and fund status.  

The goal is to simplify and bring transparency to the monthly donation process for mosques and trust-holders.

## Features

- ✅ **Collector Login / Authentication** — Authorized collectors sign in to submit donation data.  
- ✅ **House-to-House Donation Recording** — Collectors can record donations per house/family.  
- ✅ **Secure Submission & Logging** — All submitted donation amounts are stored securely.  
- ✅ **Administrative Dashboard** — For mosque/trust admins to view totals, track donation status.  
- ✅ **Donation History / Audit Trail** — Keep track of who collected how much, when.  

## Tech Stack (suggested / implied)

- Backend: PHP (or similar) + MySQL (or any SQL database) — fits well for small-medium charity systems.  
- Frontend: HTML / CSS / JavaScript — for forms, login, dashboards.  
- Secure authentication system for collectors/admins.

## Installation / Setup (example)

1. Clone this repository.  
2. Set up a database (e.g. MySQL).  
3. Configure database credentials in a config file (e.g. `config.php`).  
4. Run the provided SQL migrations / tables creation script to create necessary tables (users, donations, logs, etc.).  
5. Upload to a PHP-supported server (e.g. Apache + PHP).  
6. Ensure proper file permissions for logs/storage.  
7. Visit `/login` to create first admin, then add collectors.