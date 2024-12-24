<?php
// Programmer Name: 06
// File: delete_patient.php
// Purpose: This file allows the user to delete an existing patient from the Doctor Clinic database
//          by entering their OHIP number. It first checks if the patient exists, then asks for
//          confirmation before proceeding with the deletion. If the patient does not exist,
//          an error message is displayed.

include 'db_connect.php';  // Include the database connection file to access the database

// Check if the form was submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the OHIP number from the POST request
    $ohip = $_POST['ohip'];

    // Check if the patient exists in the database using the provided OHIP number
    $check_patient = "SELECT * FROM patient WHERE ohip = '$ohip'";
    $result = $conn->query($check_patient);

    // If patient exists, ask for confirmation to delete
    if ($result->num_rows > 0) {
        // If confirmation is received, delete the patient from the database
        if (isset($_POST['confirm']) && $_POST['confirm'] == "Yes") {
            // SQL query to delete the patient
            $delete_patient = "DELETE FROM patient WHERE ohip = '$ohip'";
            if ($conn->query($delete_patient) === TRUE) {
                echo "<p style='color:green;'>Patient deleted successfully.</p>";
            } else {
                // If there was an error deleting, show an error message
                echo "<p style='color:red;'>Error deleting patient: " . $conn->error . "</p>";
            }
        } else {
            // Display the confirmation form to confirm the deletion
            echo "<p>Are you sure you want to delete this patient?</p>";
            echo "<form method='post'>
                    <input type='hidden' name='ohip' value='$ohip'>
                    <input type='submit' name='confirm' value='Yes'>
                    <input type='submit' name='confirm' value='No'>
                  </form>";
        }
    } else {
        // If the patient was not found, display an error message
        echo "<p style='color:red;'>Patient not found.</p>";
    }
} else {
    // If no form submission, display the form to input OHIP number for deletion
    echo "<div class='container'>
            <h2>Delete Patient</h2>
            <form method='post'>
                <label for='ohip'>Enter OHIP Number:</label>
                <input type='text' name='ohip' id='ohip' required>
                <button type='submit'>Delete Patient</button>
            </form>
          </div>";
}

// Close the database connection after completing the task
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Patient</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
            background-color: #cbe5c3; /* Set the background color */
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
        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        form input[type="text"],
        form button,
        form input[type="submit"] {
            margin-top: 10px;
            padding: 8px 12px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }
        button, input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover, input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <!-- Link to go back to the main menu -->
    <div class="back-button">
        <a href="mainmenu.php" style="text-decoration: none; color: blue;">&larr; Back to Main Menu</a>
    </div>
</body>
</html>
