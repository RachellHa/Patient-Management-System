<?php
// Programmer Name: 06
// Purpose: This file retrieves and displays information about nurses and the doctors they work with.
//          It allows the user to select a nurse and view the doctors associated with that nurse,
//          along with the total hours worked. It also shows the supervisor of the selected nurse.

include('db_connect.php'); // Includes the database connection file to interact with the database

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nurse and Doctor Information</title>
    <style>
        /* CSS Styles for the page */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #cbe5c3; /* Set background color */
        }
        .container {
            text-align: center;
            width: 80%;
            max-width: 600px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            text-align: left;
        }
        table {
            border-collapse: collapse;
            margin: 20px auto;
            width: 100%;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }
        form {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Back Button for navigation to the main menu -->
    <div class="back-button">
        <a href="mainmenu.php" style="text-decoration: none; color: blue;">&larr; Back to Main Menu</a>
    </div>

    <!-- Container holding the nurse selection form and information display -->
    <div class="container">
        <!-- Heading of the page -->
        <h2>Nurse and Doctor Information</h2>

        <!-- Form for selecting a nurse and displaying their associated doctors -->
        <form method="post" action="nurse_info.php">
            <label for="nurseid">Select Nurse:</label>
            <select name="nurseid" id="nurseid" required>
                <option value="">Select Nurse</option>
                <?php
                // Fetch nurses from the database for the dropdown selection
                $nurses_sql = "SELECT nurseid, firstname, lastname FROM nurse";
                $nurses_result = $conn->query($nurses_sql); // Execute the SQL query to get nurses
                // Loop through the result set to populate the dropdown with nurse names
                while ($nurse = $nurses_result->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($nurse['nurseid']) . "'>" . htmlspecialchars($nurse['firstname']) . " " . htmlspecialchars($nurse['lastname']) . "</option>";
                }
                ?>
            </select>
            <input type="submit" value="Get Information">
        </form>

        <?php
        // Check if the form was submitted and a nurse ID was selected
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nurseid'])) {
            $nurseid = $_POST['nurseid']; // Get the selected nurse ID

            // SQL query to fetch associated doctors and the hours worked by the selected nurse
            $sql = "SELECT n.firstname AS 'Nurse First Name', n.lastname AS 'Nurse Last Name', 
                           d.firstname AS 'Doctor First Name', d.lastname AS 'Doctor Last Name', w.hours
                    FROM nurse n
                    JOIN workingfor w ON n.nurseid = w.nurseid
                    JOIN doctor d ON w.docid = d.docid
                    WHERE n.nurseid = ?";
            // Prepare the SQL query to prevent SQL injection
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $nurseid); // Bind the nurse ID parameter
            $stmt->execute(); // Execute the query
            $result = $stmt->get_result(); // Get the result set
            $total_hours = 0; // Initialize total hours worked by the nurse

            // Display the results in a table format
            echo "<table><tr><th>Nurse First Name</th><th>Nurse Last Name</th><th>Doctor First Name</th><th>Doctor Last Name</th><th>Hours Worked</th></tr>";
            if ($result->num_rows > 0) {
                // Loop through the result set and display each record in the table
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . htmlspecialchars($row["Nurse First Name"]) . "</td><td>" . htmlspecialchars($row["Nurse Last Name"]) . "</td><td>" . htmlspecialchars($row["Doctor First Name"]) . "</td><td>" . htmlspecialchars($row["Doctor Last Name"]) . "</td><td>" . htmlspecialchars($row["hours"]) . "</td></tr>";
                    $total_hours += $row["hours"]; // Add the hours to the total
                }
                echo "</table>"; // Close the table
                echo "<p>Total Hours Worked: " . $total_hours . "</p>"; // Display total hours worked by the nurse
            } else {
                // If no records are found, display this message
                echo "<p>No doctors assigned to this nurse.</p>";
            }

            // SQL query to fetch the nurse's supervisor information
            $sql_supervisor = "SELECT firstname, lastname FROM nurse WHERE nurseid = (SELECT reporttonurseid FROM nurse WHERE nurseid = ?)";
            // Prepare the query to prevent SQL injection
            $stmt_supervisor = $conn->prepare($sql_supervisor);
            $stmt_supervisor->bind_param("s", $nurseid); // Bind the nurse ID parameter
            $stmt_supervisor->execute(); // Execute the query
            $supervisor_result = $stmt_supervisor->get_result(); // Get the result set

            // Check if a supervisor exists and display their information
            if ($supervisor_result->num_rows > 0) {
                $supervisor = $supervisor_result->fetch_assoc(); // Fetch supervisor's details
                echo "<p>Supervisor: " . htmlspecialchars($supervisor['firstname']) . " " . htmlspecialchars($supervisor['lastname']) . "</p>";
            } else {
                // If no supervisor is found, display this message
                echo "<p>Supervisor: None</p>";
            }
        }
        $conn->close(); // Close the database connection after the operation
        ?>
    </div>
</body>
</html>
