<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $package_name = $_POST['package_name'];
    $package_description = $_POST['package_description'];

    $stmt = $conn->prepare("INSERT INTO packages (name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $package_name, $package_description);
    $stmt->execute();
    $stmt->close();

    header("Location: packages.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj pakiet</title>
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
        <h2 class="mt-5">Dodaj nowy pakiet</h2>
        <form method="POST" action="add_package.php">
            <div class="mb-3">
                <label for="package_name" class="form-label">Nazwa pakietu</label>
                <input type="text" id="package_name" name="package_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="package_description" class="form-label">Opis pakietu</label>
                <textarea id="package_description" name="package_description" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Dodaj pakiet</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>