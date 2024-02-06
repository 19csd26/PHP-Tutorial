<!DOCTYPE html>
<html>
<body>

<?php
//Traits are used to declare methods that can be used in multiple classes. 
//Traits can have methods and abstract methods that can be used in multiple classes, 
//and the methods can have any access modifier (public, private, or protected).
//Traits are declared with the trait keyword
trait message1 {
  public function msg1() {
    echo "OOP is fun! "; 
  }
}

class Welcome {
  use message1;
}
class wel{
	use message1;
    
}

$obj = new Welcome();
$obj->msg1();
$obj = new wel();
$obj->msg1();
?>
 
</body>
</html>
