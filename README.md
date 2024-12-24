# Patient Management Web Application

## Overview
This web application allows users to manage a patient database using a web interface. The application is implemented using PHP, MySQL, HTML, and CSS. JavaScript is optional and not used in this project. Users can view, update, insert, and delete records from the database.

## Features
The application supports the following features:

1. **Main Menu**: A landing page (`mainmenu.php`) with navigation options for the user to choose tasks.

2. **List Patients**:
   - Displays all patients with their details.
   - Allows sorting by First Name or Last Name.
   - Supports ascending and descending order for sorting.
   - Displays the doctor’s First Name and Last Name for each patient.
   - Converts weight and height between metric (kg, cm) and imperial (lbs, ft, in) units.

3. **Insert Patient**:
   - Prompts the user to input patient details.
   - Ensures the entered OHIP number is unique.
   - Allows selection of a doctor for the new patient.
   - Displays an error message if the OHIP number is already in use.

4. **Delete Patient**:
   - Prompts for an OHIP number or allows selection of a patient from a list.
   - Confirms the deletion with a warning prompt.
   - Displays an error if the OHIP number does not exist.

5. **Modify Patient**:
   - Allows updating the weight of a patient.
   - Accepts input in pounds or kilograms and stores it in kilograms.

6. **List Doctors Without Patients**:
   - Displays the First and Last Name and Doctor ID of doctors with no assigned patients.

7. **List Doctors and Their Patients**:
   - Displays the First and Last Name of doctors and the First and Last Name of their assigned patients.

8. **Nurse Hours**:
   - Prompts for a nurse’s name.
   - Displays the nurse’s First and Last Name, doctors they work for, hours worked for each doctor, and the total hours worked.
   - Displays the First and Last Name of the nurse’s supervisor.

## File Structure
```
/public_html/
|-- a3whale/
    |-- mainmenu.php          # Main menu with navigation options
    |-- listpatients.php      # List and sort patients
    |-- insertpatient.php     # Insert new patient
    |-- deletepatient.php     # Delete an existing patient
    |-- modifypatient.php     # Modify patient details
    |-- doctorswithoutpatients.php  # Display doctors without patients
    |-- doctorspatients.php   # List doctors and their patients
    |-- nursehours.php        # Display nurse hours and supervisor
    |-- db_connect.php        # Database connection setup
    |-- styles.css            # Custom CSS for styling
    |-- scripts/
        |-- functions.php     # Common functions used in the project
```

## Instructions to Run
1. **Upload Files**:
   - Use `scp` or an FTP client to upload the project folder `a3whale` to your virtual machine under `/home/your_username/public_html/`.

2. **Set Permissions**:
   ```bash
   chmod 755 a3whale
   chmod 644 a3whale/*
   ```

3. **Set Up Database**:
   - Log in to MySQL and create the required tables using the script from Assignment 2.
   - Populate the database with data using the provided SQL file:
     ```bash
     mysql -u your_mysql_username -p your_database_name < moredatafall2024.sql
     ```
