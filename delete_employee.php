<?php
include 'db.php';

if (isset($_GET['id'])) {
    $employee_id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM client_employee WHERE employee_id = ?");
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $stmt->close();

    header("Location: employees.php");
    exit();
}
?>