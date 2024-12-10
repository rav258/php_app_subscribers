# Projekt: Zarządzanie Listą Subskrybentów

## Opis

Aplikacja umożliwia zarządzanie listą subskrybentów oraz rejestrację akcji takich jak dodanie, edycja i usunięcie
użytkownika. Wszystkie akcje są rejestrowane w tabeli `audit_subscribers` w bazie danych.

## Funkcjonalności

- Dodawanie subskrybentów.
- Wyświetlanie listy subskrybentów.
- Edycja subskrybentów.
- Usuwanie subskrybentów.
- Rejestrowanie historii akcji na subskrybentach.

## Wymagania

- PHP >= 7.4 z PDO.
- Serwer MySQL.
- Przeglądarka z obsługą HTML5.

## Instalacja


Skopiuj repozytorium projektu:
```bash
git clone https://github.com/rav258/php_app_subscribers.git
```

## Konfiguracja pliku `config.php`

```php
<?php
$host = "localhost";
$username = "username";
$password = "your_password";
$database = "test";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Nie można się połączyć z bazą danych: " . $e->getMessage());
}
?>

```

# SQL: Struktura bazy danych i wyzwalacze

## Tworzenie bazy danych

```sql
CREATE DATABASE IF NOT EXISTS test;
USE test;
```

## Struktura tabeli dla tabeli `subscribers`

```sql
CREATE TABLE subscribers
(
    id    INT AUTO_INCREMENT PRIMARY KEY, -- Kolumna przechowująca unikalny identyfikator dla każdego użytkownika
    fname VARCHAR(100) NOT NULL,          -- Kolumna przechowująca imię użytkownika, maksymalnie 100 znaków
    email VARCHAR(100) NOT NULL           -- Kolumna przechowująca adres e-mail użytkownika, maksymalnie 100 znaków
);
```

## Struktura tabeli dla tabeli `audit_subscribers`

```sql
CREATE TABLE audit_subscribers
(
    id               INT AUTO_INCREMENT PRIMARY KEY,     -- Kolumna przechowująca unikalny identyfikator dla każdej akcji
    subscriber_name  VARCHAR(100) NOT NULL,              -- Kolumna przechowująca imię użytkownika, na którym wykonano akcję
    action_performed VARCHAR(255) NOT NULL,              -- Kolumna przechowująca opis wykonanej akcji (np. "Insert a new subscriber")
    date_added       TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Kolumna automatycznie zapisująca datę i czas dodania akcji
);
```

## Wyzwalacz: Dodawanie wpisu do tabeli `audit_subscribers` przed dodaniem użytkownika

```sql
DELIMITER $$
CREATE TRIGGER before_subscriber_insert
    BEFORE INSERT
    ON subscribers
    FOR EACH ROW
BEGIN
    INSERT INTO audit_subscribers (subscriber_name, action_performed)
    VALUES (NEW.fname, 'Insert a new subscriber'); -- Dodanie wpisu o dodaniu nowego użytkownika
END$$
DELIMITER ;
```

## Wyzwalacz: Dodawanie wpisu do tabeli `audit_subscribers` po usunięciu użytkownika

```sql
DELIMITER $$
CREATE TRIGGER after_subscriber_delete
    AFTER DELETE
    ON subscribers
    FOR EACH ROW
BEGIN
    INSERT INTO audit_subscribers (subscriber_name, action_performed)
    VALUES (OLD.fname, 'Deleted a subscriber'); -- Dodanie wpisu o usunięciu użytkownika
END$$
DELIMITER ;
```

## Wyzwalacz: Dodawanie wpisu do tabeli `audit_subscribers` po edycji użytkownika

```sql
DELIMITER $$
CREATE TRIGGER after_subscriber_edit
    AFTER UPDATE
    ON subscribers
    FOR EACH ROW
BEGIN
    INSERT INTO audit_subscribers (subscriber_name, action_performed)
    VALUES (NEW.fname, 'Updated a subscriber'); -- Dodanie wpisu o edycji użytkownika
END$$
DELIMITER ;
```


## Technologia

- Backend: PHP z PDO.
- Frontend: HTML5, Bootstrap 5 (opcjonalnie do stylowania).
- Baza Danych: MySQL.



