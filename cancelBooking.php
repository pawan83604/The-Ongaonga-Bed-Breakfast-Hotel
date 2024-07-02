<?php

$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "bnb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $booking_id = intval($_GET['bookingID']);

    // Check if the booking exists
    $stmt = $conn->prepare("SELECT 1 FROM bookings WHERE booking_id = ?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        // Booking not found
        $response = ['message' => 'Booking not found'];
        http_response_code(404);
    } else {
        // Delete the booking
        $stmt = $conn->prepare("DELETE FROM bookings WHERE booking_id = ?");
        $stmt->bind_param("i", $booking_id);

        if ($stmt->execute()) {
            // Booking deleted successfully
            $response = ['message' => 'Booking canceled successfully'];
            http_response_code(200);
        } else {
            // Error deleting the booking
            $response = ['message' => 'Failed to cancel booking'];
            http_response_code(500);
        }
    }

    $stmt->close();
}

$conn->close();
?>
