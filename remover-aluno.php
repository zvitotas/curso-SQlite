<?php

require_once 'vendor/autoload.php';

$databasePath = __DIR__ . '/banco.sqlite';
$pdo = new PDO('sqlite:' . $databasePath);

$sqlDelete = "DELETE FROM aluno WHERE id = ?";
$preparedStatement = $pdo->prepare($sqlDelete = 'DELETE FROM students WHERE id = ?;');
$preparedStatement->bindValue(1, 5, PDO::PARAM_INT);
var_dump($preparedStatement->execute());
