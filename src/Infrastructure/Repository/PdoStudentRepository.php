<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Model\Phone;
use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Domain\Repository\StudentRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Override;
use PDO;
use PDOStatement;

class PdoStudentRepository implements StudentRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function allStudents(): array
    {
        $sqlQuery = 'SELECT * FROM students;';
        $stmt = $this->connection->query($sqlQuery);

        return $this->hydrateStudentList($stmt);
    }
    public function studentsBirthAt(DateTimeInterface $birthDate): array
    {
        $sqlQuery = 'SELECT * FROM students WHERE birth_date = :birth_date;';
        $stmt = $this->connection->prepare($sqlQuery);
        $stmt->execute([
            ':birth_date' => $birthDate->format('Y-m-d')
        ]);

        return $this->hydrateStudentList($stmt);
    }

    public function save(Student $student): bool
    {
        if ($student->id() === null) {
            return $this->insert($student);
        }

        return $this->update($student);
    }

    public function remove(Student $student): bool
    {
        $stmt = $this->connection->prepare('DELETE FROM students WHERE id = :id;');
        return $stmt->execute([
            ':id' => $student->id()
        ]);
    }

    /**
     * Helper method to convert database rows into Student objects
     * @param PDOStatement $stmt
     * @return Student[]
     */
    private function hydrateStudentList(PDOStatement $stmt): array
    {
        $studentDataList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $studentList = [];

        foreach ($studentDataList as $studentData) {
            $studentList = new Student(
                $studentData['id'],
                $studentData['name'],
                new DateTimeImmutable($studentData['birth_date'])
            );
        }

        return $studentList;
    }

    private function insert(Student $student): bool
    {
        $sqlInsert = "INSERT INTO students (name, birth_date) VALUES (:name, :birth_date);";
        $stmt = $this->connection->prepare($sqlInsert);

        $success = $stmt->execute([
            ':name' => $student->name(),
            ':birth_date' => $student->birthDate()->format('Y-m-d'),
        ]);

        if ($success) {
            $student->defineId($this->connection->lastInsertId());
        }

        return $success;
    }

    private function update(Student $student): bool
    {
        $sqlUpdate = "UPDATE students SET name = :name, birth_date = :birth_date WHERE id = :id;";
        $stmt = $this->connection->prepare($sqlUpdate);

        return $stmt->execute([
            ':name' => $student->name(),
            ':birth_date' => $student->birthDate()->format('Y-m-d'),
            ':id' => $student->id(),
        ]);
    }

    public function studentsWithPhones(): array
    {
        $sqlQuery = 'SELECT 
        students.id,
         students.name,
          students.birth_date,
          phones.id AS phone_id,
          phones.area_code,
          phones_number,
          FROM students
          JOIN phones ON students.id = phones.student_id;';
          $stmt = $this->connection->query($sqlQuery);
          $result = $stmt->fetchAll();
          $studentList = [];

          foreach ($result as $row) {
          if (array_key_exists($row ['id'], $studentList)) {
            $phone = new Phone($row['phone_id'], $row['area_code'], $row['number']);

          }
       }
    }  
}