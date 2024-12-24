<?php
// Programmer Name: 06
// Purpose: This file allows users to update the weight of an existing patient in the Doctor Clinic database.
//          It accepts input for OHIP number, weight, and unit (kilograms or pounds), and updates the patient's
//          weight in the database, converting the weight to kilograms if it's entered in pounds. 

include 'db_connect.php';  // Include the database connection file to access the database

// Check if the form was submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the OHIP number, weight, and unit from the POST request
    $ohip = $_POST['ohip'];
    $weight = $_POST['weight'];
    $unit = $_POST['unit'];

    // Convert weight to kilograms if it's in pounds
    if ($unit == 'pounds') {
        $weight = $weight / 2.205; // Convert pounds to kilograms
    }

    // Prepare SQL query to update the patient's weight in the database
    $update_sql = "UPDATE patient SET weight = ? WHERE ohip = ?";
    $stmt = $conn->prepare($update_sql);  // Prepare the SQL statement
    $stmt->bind_param("ds", $weight, $ohip);  // Bind the weight and OHIP parameters to the SQL query

    // Execute the query and check if the update was successful
    if ($stmt->execute()) {
        echo "<p style='color:green;'>Patient's weight updated to " . round($weight, 2) . " kg.</p><br>";
    } else {
        // If there was an error updating, show an error message
        echo "<p style='color:red;'>Error updating patient's weight.</p><br>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Patient Weight</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
            background-color: #cbe5c3; /* Set the background color */
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
        }
        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        form input[type="text"],
        form input[type="number"],
        form select,
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

    <!-- Form to update patient weight -->
    <div class="container">
        <h2>Update Patient Weight</h2>
        <form method="POST" action="update_patient.php">
            <label for="ohip">Enter OHIP Number:</label>
            <input type="text" id="ohip" name="ohip" required>
            <label for="weight">Enter Weight:</label>
            <input type="number" id="weight" name="weight" required>
            <label for="unit">Select Unit:</label>
            <select id="unit" name="unit">
                <option value="kilograms">Kilograms</option>
                <option value="pounds">Pounds</option>
            </select>
            <input type="submit" value="Update Weight">
        </form>
    </div>
</body>
</html>

<?php 
// Close the database connection after completing the task
$conn->close(); 
?>

