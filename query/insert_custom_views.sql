USE test;

--
-- Widok wyświetlający nazwę użytkowników oraz datę ich dodania
--
CREATE VIEW view_user_addition AS
SELECT subscriber_name AS name,
       date_added      AS date
FROM audit_subscribers
WHERE action_performed = 'Insert a new subscriber';


--
-- Widok wyświetlający nazwę użytkowników oraz datę ich usunięcia
--
CREATE VIEW view_user_deletion AS
SELECT subscriber_name AS name,
       date_added      AS date
FROM audit_subscribers
WHERE action_performed = 'Deleted a subscriber';


--
-- Widok wyświetlający nazwę użytkowników oraz datę ich edycji
--
CREATE VIEW view_user_update AS
SELECT subscriber_name AS name,
       date_added      AS date
FROM audit_subscribers
WHERE action_performed = 'Updated a subscriber';


--
-- Widok wyświetlający nazwę już usuniętych użytkowników oraz daty ich dodania i usunięcia
--
CREATE VIEW view_removed_users AS
SELECT add_actions.subscriber_name AS name,
       add_actions.date_added      AS date_added,
       delete_actions.date_added   AS date_deleted
FROM audit_subscribers AS add_actions
         INNER JOIN
     audit_subscribers AS delete_actions
     ON add_actions.subscriber_name = delete_actions.subscriber_name
WHERE add_actions.action_performed = 'Insert a new subscriber'
  AND delete_actions.action_performed = 'Deleted a subscriber'
  AND add_actions.date_added < delete_actions.date_added;


--
-- Widok wyświetlający tylko istniejących użytkowników (bez korzystania z tabelki `subscribers`)
--
CREATE VIEW view_existing_users AS
SELECT subscriber_name AS name
FROM audit_subscribers
WHERE action_performed = 'Insert a new subscriber'
  AND subscriber_name NOT IN (SELECT subscriber_name
                              FROM audit_subscribers
                              WHERE action_performed = 'Deleted a subscriber');
