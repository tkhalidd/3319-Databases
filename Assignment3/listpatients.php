<!DOCTYPE html>
<html>
<head>
    <title>List All Patients</title>
    <link rel="stylesheet" type="text/css" href="styles.css"> <!-- Link to shared CSS for consistent styling -->
</head>
<body>
    <header>
        <h1>List of All Patients</h1>
    </header>

    <!-- Form for sorting options -->
    <form method="get" style="text-align: center; margin: 20px;">
        <label>Sort By:</label>
        <input type="radio" name="sortBy" value="firstname" checked> First Name
        <input type="radio" name="sortBy" value="lastname"> Last Name
        <label>Order:</label>
        <input type="radio" name="order" value="ASC" checked> Ascending
        <input type="radio" name="order" value="DESC"> Descending
        <button type="submit">Sort</button> <!-- Submit button to apply sorting options -->
    </form>

    <?php
    // Connect to the database
    $conn = new mysqli('localhost', 'root', 'cs3319', 'assign2db');
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    // Get sorting options from form input or set defaults
    $sortBy = $_GET['sortBy'] ?? 'lastname';
    $order = $_GET['order'] ?? 'ASC';

    // Query to fetch all patients with their assigned doctor information
    $sql = "SELECT p.*, d.firstname AS doctor_firstname, d.lastname AS doctor_lastname 
            FROM patient p
            JOIN doctor d ON p.treatsdocid = d.docid
            ORDER BY $sortBy $order";

    $result = $conn->query($sql);

    // Start rendering the patient table
    echo '<table>';
    echo '<tr>
            <th>OHIP</th><th>First Name</th><th>Last Name</th><th>Weight</th>
            <th>Height</th><th>Doctor</th>
          </tr>';

    if ($result->num_rows > 0) {
        // Display each patient's data in a table row
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td>' . $row['ohip'] . '</td>
                    <td>' . $row['firstname'] . '</td>
                    <td>' . $row['lastname'] . '</td>
                    <td>' . $row['weight'] . ' kg</td>
                    <td>' . $row['height'] . ' m</td>
                    <td>' . $row['doctor_firstname'] . ' ' . $row['doctor_lastname'] . '</td>
                  </tr>';
        }
    } else {
        // Show a message if no patients are found
        echo '<tr><td colspan="6">No patients found.</td></tr>';
    }

    echo '</table>';
    $conn->close(); // Close the database connection
    ?>

    <footer>
        &copy; 2024 Healthcare Database | <a href="mailto:tkhalid8@uwo.ca?subject=Healthcare Database Support">Contact Support</a>
    </footer>
</body>
</html>
