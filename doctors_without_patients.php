<?php
// Programmer Name: 06
// Purpose: This file displays a list of doctors who currently do not have any patients assigned to them.
//          It queries the database to find doctors without patients, and presents the results

include('db_connect.php');

// Query to fetch doctors without patients from the database
$query = "SELECT d.firstname, d.lastname, d.docid
          FROM doctor d
          LEFT JOIN patient p ON d.docid = p.treatsdocid
          WHERE p.ohip IS NULL"; // LEFT JOIN ensures we get all doctors even if they have no patients
$result = mysqli_query($conn, $query); // Executes the query on the database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctors Without Patients</title>
    <style>
        /* Styles for the page layout and design */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
            background-color: #cbe5c3; /* Background color set to #cbe5c3 */
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
            max-width: 400px;
        }

        .doctor-info {
            margin-bottom: 15px;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <!-- Navigation link to go back to the main menu -->
    <div class="back-button">
        <a href="mainmenu.php" style="text-decoration: none; color: blue;">&larr; Back to Main Menu</a>
    </div>

    <!-- Displaying the doctors who do not have patients -->
    <div class="container">
        <h2>Doctors Without Patients</h2>
        <?php
        // Check if the query returned any results
        if (mysqli_num_rows($result) > 0) {
            // Loop through each doctor in the result set and display their details
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='doctor-info'>";
                echo "<strong>Doctor ID:</strong> " . htmlspecialchars($row['docid']) . "<br>";
                echo "<strong>First Name:</strong> " . htmlspecialchars($row['firstname']) . "<br>";
                echo "<strong>Last Name:</strong> " . htmlspecialchars($row['lastname']) . "<br>";
                echo "</div>";
            }
        } else {
            // If no doctors without patients are found, inform the user
            echo "<p>No doctors without patients.</p>";
        }
        ?>
    </div>
</body>
</html>

<?php 
// Close the database connection after the operation is complete
mysqli_close($conn);
?>
