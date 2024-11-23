<?php
include 'db.php';

function fetchPackageDetails()
{
    global $conn;
    $query = "SELECT id, name, description FROM packages";
    $result = $conn->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

$packageDetails = fetchPackageDetails();
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pakiety</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        <?php include "./css/style.css" ?>
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Agency Management</a>
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
        <h2 class="mt-5">Pakiety</h2>
        <table id="packagesTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nazwa pakietu</th>
                    <th>Opis</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($packageDetails as $detail): ?>
                    <tr>
                        <td><?= htmlspecialchars($detail['name']) ?></td>
                        <td><?= htmlspecialchars($detail['description']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#packagesTable').DataTable({
                "paging": true,
                "searching": true,
                "info": true,
                "autoWidth": false,
                "columnDefs": [{
                        "width": "30%",
                        "targets": 0
                    },
                    {
                        "width": "70%",
                        "targets": 1
                    }
                ]
            });
        });
    </script>
</body>

</html>