<?php
include 'db.php';

function fetchEmployeeDetails()
{
    global $conn;
    $query = "
        SELECT 
            e.id AS employee_id,
            e.name AS employee_name,
            e.email AS employee_email,
            e.role AS employee_role,
            GROUP_CONCAT(DISTINCT c.company_name SEPARATOR '; ') AS clients
        FROM 
            employees e
        LEFT JOIN client_employee ce ON e.id = ce.employee_id
        LEFT JOIN clients c ON ce.client_id = c.id
        GROUP BY e.id, e.name, e.email, e.role
    ";
    $result = $conn->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

$employeeDetails = fetchEmployeeDetails();
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pracownicy</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
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
        <h2 class="mt-5">Pracownicy</h2>
        <table id="employeesTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Imię i nazwisko</th>
                    <th>Email</th>
                    <th>Rola</th>
                    <th>Klienci</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employeeDetails as $detail): ?>
                    <tr>
                        <td><?= htmlspecialchars($detail['employee_name']) ?></td>
                        <td><?= htmlspecialchars($detail['employee_email']) ?></td>
                        <td><?= htmlspecialchars($detail['employee_role']) ?></td>
                        <td><?= htmlspecialchars($detail['clients'] ?? 'Brak') ?></td>
                        <td>
                            <a href="delete_employee.php?id=<?= $detail['employee_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Czy na pewno chcesz usunąć tego pracownika?');">Usuń</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#employeesTable').DataTable({
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
                        "width": "20%",
                        "targets": 2
                    },
                    {
                        "width": "30%",
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