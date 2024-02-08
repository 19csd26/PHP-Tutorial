<?php
error_reporting(0);

// Single Responsibility Principle (SRP) - User Management

class User
{
    private $id;
    private $username;
    private $email;
    private $passwordHash;

    public function __construct($id, $username, $email, $passwordHash)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
    }

    // Getters...

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPasswordHash()
    {
        return $this->passwordHash;
    }


}

// Open/Closed Principle (OCP) - PasswordResetService interface

interface PasswordResetService
{
    // Method to reset the password for a user
    public function resetPassword(User $user);
}

// Liskov Substitution Principle (LSP) - EmailPasswordResetService

class EmailPasswordResetService implements PasswordResetService
{
    // Implementation of the resetPassword method
    public function resetPassword(User $user)
    {
        // Simulate sending an email with a password reset link
        echo "Password reset link sent to {$user->getEmail()}\n";
    }
}

// Dependency Inversion Principle (DIP) - PasswordResetManager using Dependency Injection

class PasswordResetManager
{
    private $passwordResetService;

    // Constructor with Dependency Injection for the PasswordResetService
    public function __construct(PasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }

    // Method to reset the password using the injected service
    public function resetPassword(User $user)
    {
        $this->passwordResetService->resetPassword($user);
    }
}

// Database Connection

class Database
{
    private $pdo;

    // Constructor to establish a connection to the database
    public function __construct($host, $dbname, $username, $password)
    {
        try {
            $this->pdo = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    // Method to retrieve a user by ID from the database
    public function getUserById($userId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return new User($user['id'], $user['username'], $user['email'], $user['password_hash']);
        }

        return null;
    }

    // Method to save a user to the database
    public function saveUser(User $user)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :passwordHash)");
        $stmt->bindParam(':username', $user->getUsername());
        $stmt->bindParam(':email', $user->getEmail());
        $stmt->bindParam(':passwordHash', $user->getPasswordHash());
        $stmt->execute();
    }
}

// Demonstration with Database

// Database configuration
$dbConfig = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'dbname' => 'phptutorial',
];

// Create a database connection
$database = new Database($dbConfig['host'], $dbConfig['dbname'], $dbConfig['username'], $dbConfig['password']);

// Create a user and save to the database
$newUser = new User(null, 'new_user', 'new_user@example.com', password_hash('password123', PASSWORD_BCRYPT));
$database->saveUser($newUser);

// Retrieve the user by ID from the database
$userId = 1;
$retrievedUser = $database->getUserById($userId);

// Reset password for the retrieved user using the EmailPasswordResetService
$emailPasswordResetService = new EmailPasswordResetService();
$passwordResetManager = new PasswordResetManager($emailPasswordResetService);
$passwordResetManager->resetPassword($retrievedUser);
