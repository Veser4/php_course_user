<?php 

namespace App\Database;
use App\Model\User;

class UserTable 
{

    public function __construct(private \PDO $connection) 
    {

    }

    public function saveUserToDatabase(User $user): int 
    {
        $query = 'INSERT INTO user (first_name, last_name, middle_name, gender, birth_date, email, phone, avatar_path) VALUES (:first_name, :last_name, :middle_name, :gender, :birth_date, :email, :phone, :avatar_path);';
        $statement = $this->connection->prepare($query); 
        try 
        {
            $statement->execute([
                ':first_name' => !empty($user->getFirstName()) ? $user->getFirstName() : null,
                ':last_name' => !empty($user->getLastName()) ? $user->getLastName() : null,
                ':middle_name' => $user->getMiddleName(),
                ':gender' => !empty($user->getGender()) ? $user->getGender() : null,
                ':birth_date' => !empty($user->getBirthDate()) ? $user->getBirthDate() : null,
                ':email' => !empty($user->getEmail()) ? $user->getEmail() : null,
                ':phone' => !empty($user->getPhone()) ? $user->getPhone() : null,
                ':avatar_path' => $user->getAvataPath(),
            ]);
        } 
        catch (\PDOException $e) 
        {
            throw new \RuntimeException($e->getMessage(), (int) $e->getCode(), $e);
        }
    return (int) $this->connection->lastInsertId();
    }

    public function getUserFromDataBaseByID(int $id): ?User 
    {
        $query = 'SELECT user_id, first_name, last_name, middle_name, gender, birth_date, email, phone, avatar_path
            FROM user
            WHERE user_id = :user_id;';
        $statement = $this->connection->prepare($query);
        $statement->execute([
            ':user_id' => $id,
        ]);
        try 
        {
            if ($row = $statement->fetch(\PDO::FETCH_ASSOC)) 
            {
                return new User($row['user_id'], $row['first_name'], $row['last_name'], $row['middle_name'] ?? null, $row['gender'], $row['birth_date'], $row['email'], $row['phone'] ?? null, $row['avatar_path'] ?? null);;
            } 

        } 
        catch (\Exception $e) 
        {
                echo $e->getMessage();
        } 
        return null;
    }

    public function updateUserDataById(string $field, string $data, int $id): void
    {
        $query = 'UPDATE user SET ' . $field . ' = "' . $data . '" WHERE user_id = :user_id;';
        $statement = $this->connection->prepare($query);
        $statement->execute([
            ':user_id' => $id,
        ]);
    }

    public function updateUserById(User $user, int $id): void
    {
        $query = 'UPDATE user SET 
            first_name = :first_name,
            last_name = :last_name,
            middle_name = :middle_name,
            gender = :gender,
            birth_date = :birth_date,
            email = :email,
            phone = :phone,
            avatar_path = :avatar_path
            WHERE user_id = :user_id;';
        $statement = $this->connection->prepare($query);
        $statement->execute([
            ':user_id' => $id,
            ':first_name' => $user->getFirstName(),
            ':last_name' => $user->getLastName(),
            ':middle_name' => $user->getMiddleName(),
            ':gender' =>$user->getGender(),
            ':birth_date' => $user->getBirthDate(),
            ':email' => $user->getEmail(),
            ':phone' => $user->getPhone(),
            ':avatar_path' => $user->getAvataPath(),
        ]);
    }

    public function deleteUserById(int $id): void 
    {
        $query = 'DELETE FROM user WHERE user_id = :user_id;';
        $statement = $this->connection->prepare($query);
        $statement->execute([
            ':user_id' => $id,
        ]);
    }

    public function returnAllUsersFromDatabase() : array 
    {
        $query = 'SELECT * FROM user';
        $result = $this->connection->query($query);
        return $result->fetchAll();
    }
}