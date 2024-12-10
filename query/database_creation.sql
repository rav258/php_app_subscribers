--
-- Tworzenie bazy danych, jeśli nie istnieje
--
CREATE
DATABASE IF NOT EXISTS test;

USE
test;


--
-- Struktura tabeli dla tabeli `subscribers`
--
CREATE TABLE subscribers
(
    id    INT AUTO_INCREMENT PRIMARY KEY, -- Kolumna przechowująca unikalny identyfikator dla każdego użytkownika
    fname VARCHAR(100) NOT NULL,          -- Kolumna przechowująca imię użytkownika, maksymalnie 100 znaków
    email VARCHAR(100) NOT NULL           -- Kolumna przechowująca adres e-mail użytkownika, maksymalnie 100 znaków
);


--
-- Struktura tabeli dla tabeli `audit_subscribers`
--
CREATE TABLE audit_subscribers
(
    id               INT AUTO_INCREMENT PRIMARY KEY,     -- Kolumna przechowująca unikalny identyfikator dla każdej akcji
    subscriber_name  VARCHAR(100) NOT NULL,              -- Kolumna przechowująca imię użytkownika, na którym wykonano akcję
    action_performed VARCHAR(255) NOT NULL,              -- Kolumna przechowująca opis wykonanej akcji (np. "Insert a new subscriber")
    date_added       TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Kolumna automatycznie zapisująca datę i czas dodania akcji
);


--
-- Wyzwalacz: Dodawanie wpisu do tabeli `audit_subscribers` przed dodaniem użytkownika
--
DELIMITER
$$
CREATE TRIGGER before_subscriber_insert
    BEFORE INSERT
    ON subscribers
    FOR EACH ROW
BEGIN
    INSERT INTO audit_subscribers (subscriber_name, action_performed)
    VALUES (NEW.fname, 'Insert a new subscriber'); -- Dodanie wpisu o dodaniu nowego użytkownika
    END$$
    DELIMITER ;


--
-- Wyzwalacz: Dodawanie wpisu do tabeli `audit_subscribers` po usunięciu użytkownika
--
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


--
-- Wyzwalacz: Dodawanie wpisu do tabeli `audit_subscribers` po edycji użytkownika
--
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
