<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $company_name = $_POST['company_name'];
    $package_id = $_POST['package_id'];
    $contact_name = $_POST['contact_name'];
    $contact_email = $_POST['contact_email'];
    $contact_phone = $_POST['contact_phone'];
    $caregivers = $_POST['caregivers'];

    $stmt = $conn->prepare("INSERT INTO clients (company_name, package_id) VALUES (?, ?)");
    $stmt->bind_param("si", $company_name, $package_id);
    $stmt->execute();
    $client_id = $stmt->insert_id;
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO contacts (client_id, name, email, phone) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $client_id, $contact_name, $contact_email, $contact_phone);
    $stmt->execute();
    $stmt->close();

    foreach ($caregivers as $employee_id) {
        $stmt = $conn->prepare("INSERT INTO client_employee (client_id, employee_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $client_id, $employee_id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: index.php");
    exit();
}

$employees = $conn->query("SELECT id, name FROM employees")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj klienta</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        <?php include "./css/style.css" ?>
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Zarządzanie agencją</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="employees.php">Pracownicy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="packages.php">Pakiety</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h2 class="mt-5">Dodaj nowego klienta</h2>
        <form method="POST" action="add_client.php">
            <div class="mb-3">
                <label for="company_name" class="form-label">Nazwa firmy</label>
                <input type="text" id="company_name" name="company_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="package_id" class="form-label">Pakiet</label>
                <select id="package_id" name="package_id" class="form-select" required>
                    <?php
                    $result = $conn->query("SELECT id, name FROM packages");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="contact_name" class="form-label">Osoba kontaktowa</label>
                <input type="text" id="contact_name" name="contact_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="contact_email" class="form-label">Email osoby kontaktowej</label>
                <input type="email" id="contact_email" name="contact_email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="contact_phone" class="form-label">Telefon osoby kontaktowej</label>
                <input type="text" id="contact_phone" name="contact_phone" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="caregivers" class="form-label">Opiekunowie</label>
                <div id="caregivers">
                    <?php foreach ($employees as $employee): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="caregivers[]" value="<?= $employee['id'] ?>" id="caregiver_<?= $employee['id'] ?>">
                            <label class="form-check-label" for="caregiver_<?= $employee['id'] ?>">
                                <?= $employee['name'] ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Dodaj klienta</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>