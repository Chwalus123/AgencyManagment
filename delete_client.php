<?php
include 'db.php';

if (isset($_GET['id'])) {
    $client_id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM client_employee WHERE client_id = ?");
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM contacts WHERE client_id = ?");
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM clients WHERE id = ?");
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
    exit();
}
?>