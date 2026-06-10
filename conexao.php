<?php

$databasePath = __DIR__ . '/banco.sqlite';
$pdo = new PDO('sqlite:' . $databasePath);

echo "Conectei\n";

$createTableSql = 'CREATE TABLE IF NOT EXISTS students (
    id INTEGER PRIMARY KEY,
    name TEXT,
    birth_date TEXT
    );

    CREATE TABLE IF NOT EXISTS phones (
    id INTEGER PRIMARY KEY,
    area_code TEXT,
    number TEXT, -- Added the missing comma here
    student_id INTEGER,
    FOREIGN KEY (student_id) REFERENCES students(id)
    );
    ';

$pdo->exec($createTableSql);
