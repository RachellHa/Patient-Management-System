<?php
// Programmer Name: 06
// Purpose: This file is the main menu for a Doctor Clinic web application
//          It provides links to various actions a user can take, such as listing all patients,
//          adding or deleting a patient, updating patient weight, and viewing doctors or nurses.
//          Each action is linked to a specific PHP file that handles the task 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Main Menu</title>
    <!-- Link to external CSS file for additional styling -->
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Basic page styling */
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            background-color: #cbe5c3; /* Set background color */
        }

        /* Style for the container holding menu items */
        .container {
            display: inline-block;
            text-align: left;
            margin-top: 60px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 60%;
            max-width: 800px;
        }

        /* Header styles */
        h1 {
            margin-bottom: 10px;
        }
        h2 {
            margin-bottom: 20px;
        }

        /* Style for the list and buttons */
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            margin-bottom: 10px;
        }
        ul li a button {
            padding: 12px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            width: 100%;
        }
        /* Hover effect for buttons */
        ul li a button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Main menu title and subtitle -->
        <h1>Doctor Clinic</h1>
        <h2>Main Menu</h2>

        <!-- Menu options list with buttons linking to different PHP scripts -->
        <ul>
            <!-- Link to list all patients, sorted by name with detailed information -->
            <li><a href="list_patients.php"><button>List All Patients</button></a></li>

            <!-- Link to add a new patient, ensuring unique OHIP number and doctor assignment -->
            <li><a href="insert_patient.php"><button>Add New Patient</button></a></li>

            <!-- Link to delete a patient, prompting for confirmation -->
            <li><a href="delete_patient.php"><button>Delete a Patient</button></a></li>

            <!-- Link to update patient weight in either pounds or kilograms, storing in kilograms -->
            <li><a href="update_patient.php"><button>Update Patient Weight</button></a></li>

            <!-- Link to show doctors who currently have no assigned patients -->
            <li><a href="doctors_without_patients.php"><button>Doctors without Patients</button></a></li>

            <!-- Link to list doctors and their respective patients -->
            <li><a href="doctor_patient_list.php"><button>Doctors and Their Patients</button></a></li>

            <!-- Link to display detailed nurse information, including hours worked and supervisor details -->
            <li><a href="nurse_info.php"><button>Nurse Information</button></a></li>
        </ul>
    </div>
</body>
</html>
