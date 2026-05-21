<?php

$databasePath = __DIR__ . '/banco.sqlite';

$pdo = new PDO('sqlite:' . $databasePath);

$pdo->exec('DELETE FROM students');

echo "Banco limpo";