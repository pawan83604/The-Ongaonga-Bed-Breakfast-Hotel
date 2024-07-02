<?php

$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "bnb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "PUT" || $_SERVER["REQUEST_METHOD"] == "PATCH") {
    $booking_id = intval($_GET['bookingID']);
    $json_data = file_get_contents("php://input");
    $updated_data = json_decode($json_data, true);

    $new_checkin = $updated_data['checkin'];
    $new_checkout = $updated_data['checkout'];
    $new_room_id = intval($updated_data['room_id']);

    $sql = "UPDATE bookings SET checkin=?, checkout=?, room_id=? WHERE booking_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $new_checkin, $new_checkout, $new_room_id, $booking_id);

    if ($stmt->execute()) {
        $response = ['message' => 'Booking updated successfully'];
        http_response_code(200);
    } else {
        $response = ['message' => 'Failed to update booking'];
        http_response_code(500);
    }
    
    echo json_encode($response);
    $stmt->close();
}

$conn->close();
?>
