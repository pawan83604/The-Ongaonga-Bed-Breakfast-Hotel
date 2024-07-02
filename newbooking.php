<?php

$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "bnb";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_data = json_decode(file_get_contents("php://input"), true);

    $customer_id = intval($booking_data['customer_id']);
    $room_id = intval($booking_data['room_id']);
    $checkin = $booking_data['checkin'];
    $checkout = $booking_data['checkout'];

    $stmt = $conn->prepare("INSERT INTO bookings (customer_id, room_id, checkin, checkout) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $customer_id, $room_id, $checkin, $checkout);

    if ($stmt->execute()) {
        $response = [
            'message' => 'Booking created successfully',
            'booking_id' => $stmt->insert_id
        ];
        http_response_code(201);
    } else {
        $response = ['message' => 'Failed to create booking'];
        http_response_code(500);
    }

    echo json_encode($response);
    $stmt->close();
}

$conn->close();
?>
