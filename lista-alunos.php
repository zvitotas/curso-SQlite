<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$databasePath = __DIR__ . '/banco.sqlite';
$pdo = new PDO(dsn: 'sqlite:' . $databasePath);

$statement = $pdo->query(query: 'SELECT * FROM students;');

// 1. Initialize the array BEFORE the loop
$studentList = [];

// 2. Loop through the database rows
while ($studentData = $statement->fetch(PDO::FETCH_ASSOC)) {
    $student = new Student(
            $studentData['id'],
            $studentData['name'],
            new \DateTimeImmutable($studentData['birth_date'])
    );

    // This prints the ages (15)
    echo $student->age() . PHP_EOL;

    // 3. Save the student object into your array right here
    $studentList[] = $student;
}

// 4. Dump the array (it will no longer be empty!)
var_dump($studentList);
