<?php
// Programmer Name: 06
// Purpose: This file allows users to add a new patient to the Doctor Clinic database.
//          It includes input fields for OHIP number, first name, last name, weight, height,
//          and a dropdown for selecting an assigned doctor. The file verifies the uniqueness
//          of the OHIP number and displays appropriate messages if the patient is added
//          successfully or if there are any errors.

include 'db_connect.php'; // Connect to the database using an external file for reusability.

// Check if the form has been submitted via POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data for the new patient
    $ohip = $_POST['ohip'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $docid = $_POST['docid'];

    // Check if the OHIP number already exists in the patient database
    $check_sql = "SELECT * FROM patient WHERE ohip = '$ohip'";
    $check_result = $conn->query($check_sql);
    if ($check_result->num_rows > 0) {
        // Display an error message if the OHIP number is already in use
        echo "<p style='color:red;'>OHIP number already in use!</p>";
    } else {
        // Insert the new patient record into the database
        $sql = "INSERT INTO patient (ohip, firstname, lastname, weight, height, treatsdocid)
                VALUES ('$ohip', '$firstname', '$lastname', '$weight', '$height', '$docid')";
        if ($conn->query($sql) === TRUE) {
            // Display a success message if the patient was added successfully
            echo "<p style='color:green;'>New patient added successfully!</p>";
        } else {
            // Display an error message if there was an issue with the insertion
            echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Patient</title>
    <style>
        /* Styling for the page layout and components */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            text-align: center;
            background-color: #cbe5c3; /* Set background color as per requirement */
        }
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 16px;
        }
        .container {
            display: inline-block;
            text-align: left;
            margin-top: 60px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        /* Styling for form labels and inputs */
        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        form input[type="text"],
        form input[type="number"],
        form select,
        form button {
            margin-top: 10px;
            padding: 8px 12px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <!-- Back button to navigate to the main menu -->
    <div class="back-button">
        <a href="mainmenu.php" style="text-decoration: none; color: blue;">&larr; Back to Main Menu</a>
    </div>

    <!-- Container for the Add New Patient form -->
    <div class="container">
        <h1>Add New Patient</h1>
        <!-- Form for adding a new patient -->
        <form method="post" action="insert_patient.php">
            <label for="ohip">OHIP Number:</label>
            <input type="text" name="ohip" id="ohip" required>

            <label for="firstname">First Name:</label>
            <input type="text" name="firstname" id="firstname" required>

            <label for="lastname">Last Name:</label>
            <input type="text" name="lastname" id="lastname" required>

            <label for="weight">Weight (kg):</label>
            <input type="number" name="weight" id="weight" required>

            <label for="height">Height (m):</label>
            <input type="number" step="0.01" name="height" id="height" required>

            <label for="docid">Doctor:</label>
            <!-- Dropdown to select a doctor for the patient -->
            <select name="docid" id="docid" required>
                <option value="">Select Doctor</option>
                <?php
                // Fetch doctors from the database for the dropdown list
                $doc_sql = "SELECT docid, firstname, lastname FROM doctor";
                $doc_result = $conn->query($doc_sql);
                while ($row = $doc_result->fetch_assoc()) {
                    // Display each doctor as an option in the dropdown
                    echo "<option value='" . htmlspecialchars($row['docid']) . "'>" . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['lastname']) . "</option>";
                }
                ?>
            </select>

            <button type="submit">Add Patient</button>
        </form>
    </div>

    <?php $conn->close(); // Close the database connection after processing is complete ?>
</body>
</html>
