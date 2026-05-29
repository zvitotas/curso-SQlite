<?php
use \Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

$repository = new PdoStudentRepository();

empty($repository->allStudents());