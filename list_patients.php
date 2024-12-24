<?php
// Programmer Name: 06
// Purpose: This file allows users to view and sort the list of all patients in the Doctor Clinic database. 
//          Users can sort the list by last name or first name in ascending or descending order.
//          Additionally, the file displays each patient's weight in both kilograms and pounds, 
//          height in meters as well as feet and inches, and shows the doctor's name assigned to each patient.

include 'db_connect.php'; // Connect to the database using an external file for reusability.

// Retrieve sorting parameters from GET request; default to sorting by 'lastname' in ascending order.
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'lastname';
$direction = isset($_GET['direction']) ? $_GET['direction'] : 'ASC';

// SQL query to fetch all patients and their assigned doctor information, sorted based on user selection.
$sql = "SELECT p.*, d.firstname AS doc_firstname, d.lastname AS doc_lastname FROM patient p
        JOIN doctor d ON p.treatsdocid = d.docid
        ORDER BY $order_by $direction";
$result = $conn->query($sql); // Execute query and store results.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient List</title>
    <style>
        /* Basic styling for body and layout */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
            background-color: #cbe5c3; /* Set background color */
        }
        
        .back-button {
            text-align: left;
            margin-bottom: 10px;
        }
        
        .sorting-form {
            display: inline-block;
            margin-bottom: 20px;
        }
        
        .sorting-form label {
            margin-right: 10px;
        }
        
        .sorting-form input[type="radio"] {
            margin-left: 5px;
            margin-right: 5px;
        }
        
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #ffffff; /* Set entire table background color to white */
        }
        
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
            background-color: #ffffff; /* Set individual cell background color to white */
        }
        
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <!-- Link to navigate back to the main menu -->
    <div class="back-button">
        <a href="mainmenu.php" style="text-decoration: none; color: blue;">&larr; Back to Main Menu</a>
    </div>

    <!-- Sorting form with radio buttons to allow sorting by Last Name/First Name and in Ascending/Descending order -->
    <form action="list_patients.php" method="get" class="sorting-form">
        <label>Sort by:</label>
        <input type="radio" name="order_by" value="lastname" <?= $order_by == 'lastname' ? 'checked' : '' ?>> Last Name
        <input type="radio" name="order_by" value="firstname" <?= $order_by == 'firstname' ? 'checked' : '' ?>> First Name
        
        <label>Order:</label>
        <input type="radio" name="direction" value="ASC" <?= $direction == 'ASC' ? 'checked' : '' ?>> Ascending
        <input type="radio" name="direction" value="DESC" <?= $direction == 'DESC' ? 'checked' : '' ?>> Descending
        
        <button type="submit">Sort</button>
    </form>

    <!-- Patient data table displaying OHIP, name, weight (kg and lbs), height (m and ft/in), and assigned doctor -->
    <table>
        <tr>
            <th>OHIP</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Weight</th>
            <th>Height</th>
            <th>Doctor</th>
        </tr>
        <?php
        // Loop through each row in the result set and display patient information.
        while ($row = $result->fetch_assoc()) {
            // Convert weight from kg to pounds and height from meters to feet/inches.
            $weight_kg = $row['weight'];
            $weight_lb = round($weight_kg * 2.20462, 2); // Convert kg to lbs with 2 decimal precision.
            
            $height_m = $row['height'];
            $height_ft = floor($height_m * 3.28084); // Calculate height in feet.
            $height_in = round(($height_m * 39.3701) % 12, 1); // Calculate remaining height in inches.
            
            // Display each patient's data in a table row.
            echo "<tr>
                    <td>{$row['ohip']}</td>
                    <td>{$row['firstname']}</td>
                    <td>{$row['lastname']}</td>
                    <td>{$weight_kg} kg / {$weight_lb} lbs</td>
                    <td>{$height_ft} ft {$height_in} in</td>
                    <td>{$row['doc_firstname']} {$row['doc_lastname']}</td>
                  </tr>";
        }
        
        // Close the database connection after retrieving data.
        $conn->close();
        ?>
    </table>
</body>
</html>
