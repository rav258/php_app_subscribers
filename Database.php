<?php
require_once "config.php";

class Database {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addSubscriber($fname, $email) {
        $stmt = $this->pdo->prepare("INSERT INTO subscribers (fname, email) VALUES (:fname, :email)");
        $stmt->execute(['fname' => $fname, 'email' => $email]);
    }

    public function getSubscribers() {
        $stmt = $this->pdo->query("SELECT * FROM subscribers");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSubscriberById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM subscribers WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateSubscriber($id, $fname, $email) {
        $stmt = $this->pdo->prepare("UPDATE subscribers SET fname = :fname, email = :email WHERE id = :id");
        $stmt->execute(['id' => $id, 'fname' => $fname, 'email' => $email]);
    }

    public function deleteSubscriber($id) {
        $stmt = $this->pdo->prepare("DELETE FROM subscribers WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
?>
