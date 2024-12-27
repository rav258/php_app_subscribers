<?php
require_once "Database.php";

$db = new Database($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'];
    $email = $_POST['email'];
    $db->addSubscriber($fname, $email);

    header("Location: viewsubscribers.php");
    exit;
}

$viewData = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['view'])) {
    $selectedView = $_GET['view'];
    $viewData = $db->getDataFromView($selectedView);
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <title>Dodaj użytkownika</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Php app">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<div class="container mt-3">
    <h2>Dodaj użytkownika</h2>
    <form method="POST">
        <div class="mb-3 mt-3">
            <label for="fname">Imię:</label>
            <input type="text" class="form-control" id="fname" placeholder="Podaj imię" name="fname" required autocomplete="off">
        </div>
        <div class="mb-3">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" placeholder="Podaj adres email" name="email">
        </div>

        <button type="submit" class="btn btn-primary">Dodaj</button>
    </form>
</div>

<hr>
<div class="container mt-3">
    <h2>Pokaż widok</h2>
    <form method="GET">
        <div class="mb-3">
            <label for="view">Wybierz widok:</label>
            <select name="view" id="view" class="form-control" onchange="saveSelectedView(this.value)">
                <option value="view_user_addition">Dodania użytkowników</option>
                <option selected value="view_user_deletion">Usunięcia użytkowników</option>
                <option value="view_user_update">Edycje użytkowników</option>
                <option value="view_removed_users">Usunięci użytkownicy</option>
                <option value="view_existing_users">Istniejący użytkownicy</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Pokaż</button>
    </form>
</div>

<?php if (!empty($viewData)): ?>
    <div class="container mt-3">
        <table class="table table-striped">
            <thead>
            <tr>
                <?php foreach (array_keys($viewData[0]) as $column): ?>
                    <th><?= htmlspecialchars($column) ?></th>
                <?php endforeach; ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($viewData as $row): ?>
                <tr>
                    <?php foreach ($row as $cell): ?>
                        <td><?= htmlspecialchars($cell) ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php if (empty($viewData)): ?>
    <div class="container mt-3">
        <div class="alert alert-danger">
            <strong>Pusto!</strong> - brak wyników.
        </div>
    </div>
<?php endif; ?>
<hr>

<script>
    function saveSelectedView(value) {
        sessionStorage.setItem("selectedView", value);
    }

    document.addEventListener("DOMContentLoaded", () => {
        const savedView = sessionStorage.getItem("selectedView");
        if (savedView) {
            document.getElementById("view").value = savedView;
        }
    });

</script>


</body>
</html>
