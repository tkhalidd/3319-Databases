<!DOCTYPE html>
<html>
<head>
    <title>Doctor Information</title>
    <link rel="stylesheet" type="text/css" href="styles.css"> <!-- Link to shared CSS file -->
</head>
<body>
    <header>
        <h1>Doctor Information</h1>
        <p>View details about doctors with or without patients below:</p>
    </header>

    <!-- Buttons to filter the doctor information -->
    <div style="text-align: center; margin: 20px;">
        <form method="get" style="display: inline;">
            <button type="submit" name="filter" value="all">Show All Doctors</button>
        </form>
        <form method="get" style="display: inline;">
            <button type="submit" name="filter" value="nopatients">Doctors with No Patients</button>
        </form>
        <form method="get" style="display: inline;">
            <button type="submit" name="filter" value="withpatients">Doctors with Patients</button>
        </form>
    </div>

    <?php
    // Connect to the database
    $conn = new mysqli('localhost', 'root', 'cs3319', 'assign2db');
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    // Determine which filter to apply
    $filter = $_GET['filter'] ?? 'all';

    // Query based on the selected filter
    if ($filter === 'nopatients') {
        $sql = "SELECT d.docid, d.firstname AS doctor_firstname, d.lastname AS doctor_lastname
                FROM doctor d
                LEFT JOIN patient p ON d.docid = p.treatsdocid
                WHERE p.treatsdocid IS NULL";
    } elseif ($filter === 'withpatients') {
        $sql = "SELECT d.docid, d.firstname AS doctor_firstname, d.lastname AS doctor_lastname,
                       p.firstname AS patient_firstname, p.lastname AS patient_lastname
                FROM doctor d
                JOIN patient p ON d.docid = p.treatsdocid
                ORDER BY d.docid";
    } else {
        $sql = "SELECT d.docid, d.firstname AS doctor_firstname, d.lastname AS doctor_lastname,
                       p.firstname AS patient_firstname, p.lastname AS patient_lastname
                FROM doctor d
                LEFT JOIN patient p ON d.docid = p.treatsdocid
                ORDER BY d.docid";
    }

    $result = $conn->query($sql);

    // Display the data in a styled table
    echo '<table>';
    echo '<tr>
            <th>Doctor ID</th>
            <th>Doctor First Name</th>
            <th>Doctor Last Name</th>
            <th>Patient First Name</th>
            <th>Patient Last Name</th>
          </tr>';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td>' . $row['docid'] . '</td>
                    <td>' . $row['doctor_firstname'] . '</td>
                    <td>' . $row['doctor_lastname'] . '</td>';
            if (isset($row['patient_firstname'])) {
                echo '<td>' . $row['patient_firstname'] . '</td>
                      <td>' . $row['patient_lastname'] . '</td>';
            } else {
                echo '<td colspan="2">No Patients</td>';
            }
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="5">No results found.</td></tr>';
    }

    echo '</table>';

    $conn->close(); // Close the database connection
    ?>

    <footer>
        &copy; 2024 Healthcare Database | <a href="mailto:tkhalid8@uwo.ca?subject=Healthcare Database Support">Contact Support</a>
    </footer>
</body>
</html>
