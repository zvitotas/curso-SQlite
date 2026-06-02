<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$databasePath = __DIR__ . '/banco.sqlite';
$pdo = new PDO(dsn: 'sqlite:' . $databasePath);

$statement = $pdo->query(query: 'SELECT * FROM students;');

$studentList = [];

while ($studentData = $statement->fetch(PDO::FETCH_ASSOC)) {
    $student = new Student(
            $studentData['id'],
            $studentData['name'],
            new \DateTimeImmutable($studentData['birth_date'])
    );

    echo $student->age() . PHP_EOL;

    $studentList[] = $student;
}

var_dump($studentList);
