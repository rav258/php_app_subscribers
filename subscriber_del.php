<?php
require_once "Database.php";

$db = new Database($pdo);

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $db->deleteSubscriber($id);

    header("Location: viewsubscribers.php");
    exit;
}
?>
