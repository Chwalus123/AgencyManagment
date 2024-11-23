<?php
include 'db.php';

function fetchClientDetails()
{
    global $conn;
    $query = "
        SELECT 
            c.id AS client_id,
            c.company_name,
            p.name AS package_name,
            GROUP_CONCAT(DISTINCT CONCAT(cnt.name, ' (', cnt.email, ', ', cnt.phone, ')') SEPARATOR '; ') AS contact_people,
            GROUP_CONCAT(DISTINCT e.name SEPARATOR '; ') AS employees
        FROM 
            clients c
        LEFT JOIN packages p ON c.package_id = p.id
        LEFT JOIN contacts cnt ON cnt.client_id = c.id
        LEFT JOIN client_employee ce ON ce.client_id = c.id
        LEFT JOIN employees e ON ce.employee_id = e.id
        GROUP BY c.id, c.company_name, p.name
    ";
    $result = $conn->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

$clientDetails = fetchClientDetails();
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzanie agencją</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <style>
        <?php include "./css/style.css" ?>
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Zarządzanie agencją</a>
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
        <h2 class="mt-5">Klienci</h2>
        <table id="clientsTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nazwa firmy</th>
                    <th>Pakiet</th>
                    <th>Osoby kontaktowe</th>
                    <th>Opiekunowie</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientDetails as $detail): ?>
                    <tr>
                        <td><?= htmlspecialchars($detail['company_name']) ?></td>
                        <td><?= htmlspecialchars($detail['package_name']) ?></td>
                        <td><?= htmlspecialchars($detail['contact_people'] ?? 'Brak') ?></td>
                        <td><?= htmlspecialchars($detail['employees'] ?? 'Brak') ?></td>
                        <td>
                            <a href="delete_client.php?id=<?= $detail['client_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Czy na pewno chcesz usunąć tego klienta?');">Usuń</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="mb-4">
            <a href="add_client.php" class="btn btn-outline-primary btn-custom">Dodaj nowego klienta</a>
            <span class="description">Formularz do dodawania nowych klientów do systemu.</span>
        </div>
        <div class="mb-4">
            <a href="add_employee.php" class="btn btn-outline-primary btn-custom">Dodaj nowego pracownika</a>
            <span class="description">Formularz do dodawania nowych pracowników agencji.</span>
        </div>
        <div class="mb-4">
            <a href="add_package.php" class="btn btn-outline-primary btn-custom">Dodaj nowy pakiet</a>
            <span class="description">Formularz do dodawania nowych pakietów dla klientów.</span>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#clientsTable').DataTable({
                "paging": true,
                "searching": true,
                "info": true,
                "autoWidth": false,
                "columnDefs": [{
                        "width": "20%",
                        "targets": 0
                    },
                    {
                        "width": "20%",
                        "targets": 1
                    },
                    {
                        "width": "30%",
                        "targets": 2
                    },
                    {
                        "width": "20%",
                        "targets": 3
                    },
                    {
                        "width": "10%",
                        "targets": 4
                    }
                ]
            });
        });
    </script>
</body>

</html>