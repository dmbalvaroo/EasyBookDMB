<?php
header('Content-Type: application/json');

require '../conexionbd.php';

$id = $_GET['id'];

$sql = "DELETE FROM Reserva WHERE id_reserva = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

$response = array();
if ($stmt->execute()) {
    $response['deleted'] = $stmt->affected_rows;
} else {
    $response['error'] = $stmt->error;
}

echo json_encode($response);

$stmt->close();
$conn->close();
?>
