<?php
require_once "Database.php";

$db = new Database($pdo);

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $subscriber = $db->getSubscriberById($id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fname = $_POST['fname'];
        $email = $_POST['email'];
        $db->updateSubscriber($id, $fname, $email);

        header("Location: viewsubscribers.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edytuj użytkownika</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Php app">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<div class="container mt-3">
    <h2>Edytuj użytkownika</h2>
    <form method="POST">
        <div class="mb-3 mt-3">
            <label for="fname">Imię:</label>
            <input value="<?php echo $subscriber['fname']; ?>" type="text" class="form-control" id="fname" name="fname">
        </div>
        <div class="mb-3">
            <label for="email">Email:</label>
            <input value="<?php echo $subscriber['email']; ?>" type="email" class="form-control" id="email" name="email">
        </div>

        <button type="submit" class="btn btn-primary">Zapisz</button>
    </form>
</div>

</body>
</html>
