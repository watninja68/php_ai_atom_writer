
<?php

require_once 'db_init.php'; // Include the database connection script

try {
    // Attempt a simple query
    $stmt = $pdo->query("SELECT 1"); // A very basic query to check the connection
    $result = $stmt->fetch();

    if ($result && $result[0] == 1) {
        echo "<p style='color: green;'>Database connection successful!</p>";

        // Example: Fetch and display some data (replace with your table/data)
        $dataStmt = $pdo->query("SELECT * FROM your_table LIMIT 5"); // Replace your_table
        if ($dataStmt) {
            echo "<h3>Example Data (First 5 rows from your_table):</h3>";
            echo "<table border='1'>";
            echo "<tr><th>Column 1</th><th>Column 2</th><th>...</th></tr>"; // Adjust column headers

            while ($row = $dataStmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['column1']) . "</td>"; // Adjust column names
                echo "<td>" . htmlspecialchars($row['column2']) . "</td>";
                echo "<td>...</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color: orange;'>Could not fetch example data (check your_table and columns exist).</p>";
        }

    } else {
        echo "<p style='color: red;'>Database connection failed (basic query failed).</p>";
    }

} catch (PDOException $e) {
    echo "<p style='color: red;'>Database connection error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

?>

