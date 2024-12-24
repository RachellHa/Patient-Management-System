<?php
// Programmer Name: 06
// Purpose: This file retrieves and displays the doctors and their assigned patients from the database.
//          It uses a LEFT JOIN to list doctors and the patients they are treating. If a doctor does not
//          have any patients, it will display "None assigned yet" for that doctor.

include('db_connect.php'); // Includes the database connection file

// SQL query to get the doctor's first and last names, along with their assigned patients' first and last names
$query = "SELECT d.firstname AS doctor_firstname, d.lastname AS doctor_lastname,
                 p.firstname AS patient_firstname, p.lastname AS patient_lastname
          FROM doctor d
          LEFT JOIN patient p ON d.docid = p.treatsdocid"; // LEFT JOIN ensures all doctors are listed even if they have no patients

// Execute the query on the database
$result = mysqli_query($conn, $query); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctors and Patients</title>
    <style>
        body {
            font-family: Arial, sans-serif; /* Sets the font for the page */
            margin: 20px;
            text-align: center;
            background-color: #cbe5c3; /* Sets the background color to #cbe5c3 */
        }

        .back-button {
            text-align: left;
            margin-bottom: 10px;
        }

        .container {
            display: inline-block;
            text-align: left;
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            max-width: 500px;
        }

        .doctor-patient-info {
            margin-bottom: 20px;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .doctor-patient-info:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <!-- Back to main menu link -->
    <div class="back-button">
        <a href="mainmenu.php" style="text-decoration: none; color: blue;">&larr; Back to Main Menu</a>
    </div>

    <!-- Displaying the doctors and their assigned patients -->
    <div class="container">
        <h2>Doctors and Their Patients</h2>
        <?php
        // Check if any records are returned from the query
        if (mysqli_num_rows($result) > 0) {
            // Loop through each doctor and display their details along with their patients
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='doctor-patient-info'>";
                // Display doctor's name
                echo "<strong>Doctor:</strong> " . htmlspecialchars($row['doctor_firstname']) . " " . htmlspecialchars($row['doctor_lastname']) . "<br>";
                
                // Check if the doctor has a patient assigned
                if ($row['patient_firstname'] && $row['patient_lastname']) {
                    // If a patient is assigned, display the patient's name
                    echo "<strong>Patient:</strong> " . htmlspecialchars($row['patient_firstname']) . " " . htmlspecialchars($row['patient_lastname']) . "<br>";
                } else {
                    // If no patient is assigned, display "None assigned yet."
                    echo "<strong>Patient:</strong> None assigned yet.<br>";
                }
                echo "</div>";
            }
        } else {
            // If no data is found, inform the user
            echo "<p>No data found.</p>";
        }
        ?>
    </div>
</body>
</html>

<?php 
// Close the database connection after the operation is complete
mysqli_close($conn); 
?>
