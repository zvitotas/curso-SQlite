<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$databasePath = __DIR__ . '/banco.sqlite';
$pdo = new PDO('sqlite:' . $databasePath);

$pdo->exec('CREATE TABLE IF NOT EXISTS students (id INTEGER PRIMARY KEY, name TEXT, birth_date TEXT);');

$student = new Student(
    null,
    "Victor', ''); DROP TABLE students; -- Rodrigues",
    new \DateTimeImmutable('2011-04-23')
);

$sqlInsert = "INSERT INTO students (name, birth_date) VALUES (:name, :birth_date))";
$statement = $pdo->prepare($sqlInsert);
$statement->bindParam(':name', $name);
$statement->bindValue(2, $student->birthDate()->format('Y-m-d'));

if ($statement->execute()) {
    echo "Aluno inserido com sucesso!";
};
