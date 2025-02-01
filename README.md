# CS3319: Database Design and Implementation

This repository contains assignments completed for CS3319 (Database Design and Implementation) at Western University.

## Assignments Overview

### Assignment 2: SQL Database Implementation

- Implementation of a healthcare database system using MySQL
- Features:
  - Complex SQL queries for patient and medical staff data
  - Data manipulation (INSERT, UPDATE, DELETE operations) 
  - Table relationships and foreign key constraints
  - Entity-Relationship diagram design
  - Join operations and aggregate functions
  - Data filtering and sorting

### Assignment 3: PHP Web Interface

- Development of a web-based interface for the healthcare database
- Features:
  - Patient management system (add, modify, delete patients)
  - Doctor and nurse information display
  - File upload functionality for banner images
  - Consistent styling using shared CSS
  - Form validation and data processing
  - Database connection handling
  - User-friendly interface components

#### Key Components:
- `mainmenu.php`: Main navigation interface
- `doctorinfo.php`: Display and filter doctor information  
- `nurseinfo.php`: Nurse information management
- `insertpatient.php`: Add new patients to the system
- `modifypatient.php`: Update patient information
- `deletepatient.php`: Remove patients from the database
- `upload.php`: Handle banner image uploads
- `styles.css`: Shared styling for consistent UI

## Course Learning Outcomes

- Understanding of database design principles
- Experience with SQL query writing and optimization
- Knowledge of PHP web development
- Implementation of CRUD operations
- Practice with web-based database interfaces
- Understanding of data relationships and constraints
- Experience with user interface design
- Implementation of file handling and image uploads

## Technologies Used

- MySQL
- PHP
- HTML
- CSS
- Apache Web Server

## Database Schema

The healthcare database includes tables for:
- Patients
- Doctors 
- Nurses
- Working relationships
- Treatment assignments

Each table is properly related using foreign key constraints to maintain data integrity.
