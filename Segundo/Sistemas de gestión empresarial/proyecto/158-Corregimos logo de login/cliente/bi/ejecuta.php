<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background-color: #f9f9f9;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        background-color: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    th, td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }
    th {
        background-color: crimson;
        color: white;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    tr:hover {
        background-color: #eaf4ff;
    }
    .row-number {
        font-weight: bold;
        text-align: center;
    }
</style>
<?php
// Database connection details
$host = "localhost";
$username = "crimson";
$password = "crimson";
$database = "crimson";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define the SQL query
$sql = $_GET['sql'];

// Execute the query
$result = $conn->query($sql);

// Function to generate table HTML
function generateTableHTML($result) {
    if ($result && $result->num_rows > 0) {
        $html = "<table border='1'>";
        
        // Fetch and display column headers dynamically
        $html .= "<tr><th>#</th>";
        $columns = $result->fetch_fields();
        foreach ($columns as $column) {
            $html .= "<th>" . htmlspecialchars($column->name) . "</th>";
        }
        $html .= "</tr>";
        
        // Display rows dynamically
        $rowNumber = 1;
        while ($row = $result->fetch_assoc()) {
            $html .= "<tr>";
            $html .= "<td>" . $rowNumber++ . "</td>";
            foreach ($row as $value) {
                $html .= "<td>" . htmlspecialchars($value) . "</td>";
            }
            $html .= "</tr>";
        }
        
        $html .= "</table>";
        return $html;
    } else {
        return "No results found.";
    }
}

// Generate table HTML
$tableHTML = generateTableHTML($result);

// Display table
echo $tableHTML;

// Generate download link
if ($result && $result->num_rows > 0) {
    $encodedTableHTML = base64_encode($tableHTML);
    echo "<form method='post' action='download.php'>";
    echo "<input type='hidden' name='table' value='" . $encodedTableHTML . "'>";
    echo "<button type='submit'>Download as HTML</button>";
    echo "</form>";
}

// Close the connection
$conn->close();
?>

