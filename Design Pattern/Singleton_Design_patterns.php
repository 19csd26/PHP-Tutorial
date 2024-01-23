/*
The Singleton Pattern:
The Singleton Pattern is a software design pattern that ensures a class has only one instance, while providing a global access point to that instance. 
This is useful in situations where it is necessary to limit the number of instances of a class, such as when managing resources or ensuring data integrity.

One real-world example of using the Singleton Pattern is in the management of user sessions in a web application. User sessions are used to track user activity and maintain state across HTTP requests. 
By using the Singleton Pattern to manage user sessions, we can ensure that there is only one instance of the session manager, and all requests for a user's session are directed to the same instance.
*/
<?php
//Singleton class for ensuring a single instance of the class.
class Singleton {
    
    /**
     * Holds the singleton instance.
     * @var Singleton|null
     */
    public static function getInstance() {
        static $instance = null;
        
        // Create a new instance only if none exists
        if (null === $instance) {
            $instance = new static();
        }
        return $instance;
    }

  // Protected constructor to prevent direct instantiation.
    protected function __construct() {
    }
    
  // Private method to prevent cloning of the instance.
    private function __clone() {
    }
    
  // Private method to prevent unserialization of the instance.
    private function __wakeup() {
    }
}

// SingletonChild class, extending Singleton, to inherit the Singleton pattern.
class SingletonChild extends Singleton {
}

// Example of using the Singleton pattern
// Create an instance of the Singleton class
$obj = Singleton::getInstance();
var_dump($obj === Singleton::getInstance());

// Create an instance of the SingletonChild class
$anotherObj = SingletonChild::getInstance();

// Check if the instances are the same
var_dump($anotherObj === Singleton::getInstance());
var_dump($anotherObj === SingletonChild::getInstance()); 
?>
