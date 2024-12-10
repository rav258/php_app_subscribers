<?php
require_once "Database.php";

$db = new Database($pdo);
$subscribers = $db->getSubscribers();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista użytkowników</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Php app">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<div class="container mt-3">
    <h2>Lista użytkowników</h2>

    <table class="table table-bordered">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Imię</th>
            <th>Email</th>
            <th>Akcje</th>
        </tr>
        </thead>

        <?php foreach ($subscribers as $subscriber) { ?>
            <tr>
                <td><?php echo $subscriber['id']; ?></td>
                <td><?php echo $subscriber['fname']; ?></td>
                <td><?php echo $subscriber['email']; ?></td>
                <td>
                    <a class="btn btn-primary" href="subscriber_edit.php?id=<?php echo $subscriber['id']; ?>">Edytuj</a>
                    <a class="btn btn-danger" href="subscriber_del.php?id=<?php echo $subscriber['id']; ?>">Usuń</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <a class="btn btn-success btn-lg" href="index.php">Dodaj nowego użytkownika</a>

</div>
</body>
</html>
