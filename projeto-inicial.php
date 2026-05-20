<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$student = new Student(
    null,
    'Victor Rodrigues',
    new \DateTimeImmutable('2011-04-23')
);

echo $student->age();
