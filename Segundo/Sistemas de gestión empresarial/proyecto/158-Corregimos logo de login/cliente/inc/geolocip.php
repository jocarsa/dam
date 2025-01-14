<?php
// Path to the MaxMind GeoLite2 database (replace with your actual path)
$geoIpDbPath = 'path/to/GeoLite2-Country.mmdb';

// Function to check if an IP address is from Spain
function isIpFromSpain($ip, $dbPath)
{
    try {
        // Open the SQLite database
        $pdo = new PDO("sqlite:$dbPath");

        // Prepare the query to check the IP address
        $stmt = $pdo->prepare("
            SELECT country_iso_code 
            FROM geoip_data 
            WHERE network = (
                SELECT network
                FROM geoip_data
                WHERE inet6_aton(?) BETWEEN network_start AND network_end
                LIMIT 1
            )
        ");

        // Bind the IP address
        $stmt->bindValue(1, $ip);
        $stmt->execute();

        // Fetch the country ISO code
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Close the database connection
        $pdo = null;

        // Return true if the country is Spain
        return $result && $result['country_iso_code'] === 'ES';
    } catch (PDOException $e) {
        // Handle database errors
        error_log("Database error: " . $e->getMessage());
        return false;
    } catch (Exception $e) {
        // Handle general errors
        error_log("Error: " . $e->getMessage());
        return false;
    }
}

// Test the function
$ip = '81.44.51.1'; // Replace with the IP address to check
if (isIpFromSpain($ip, $geoIpDbPath)) {
    echo "The IP address $ip is from Spain.";
} else {
    echo "The IP address $ip is NOT from Spain.";
}
?>

