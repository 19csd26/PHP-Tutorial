# What is an Exception?
An exception is an object that describes an error or unexpected behaviour of a PHP script.

Exceptions are thrown by many PHP functions and classes.

User defined functions and classes can also throw exceptions.

Exceptions are a good way to stop a function when it comes across data that it cannot use.

# Throwing an Exception
The throw statement allows a user defined function or method to throw an exception. When an exception is thrown, the code following it will not be executed.

If an exception is not caught, a fatal error will occur with an "Uncaught Exception" message.

<h3>Example</h3>
</pre>
<?php
function divide($dividend, $divisor) {
  if($divisor == 0) {
    throw new Exception("Division by zero");
  }
  return $dividend / $divisor;
}

echo divide(5, 0);
?>
</pre>
# The try...catch Statement
To avoid the error from the example above, we can use the try...catch statement to catch exceptions and continue the process.

<h4> Syntax </h4>
try {
  code that can throw exceptions
} catch(Exception $e) {
  code that runs when an exception is caught
}

<h3>Example</h3>
<pre>
<?php
function divide($dividend, $divisor) {
  if($divisor == 0) {
    throw new Exception("Division by zero");
  }
  return $dividend / $divisor;
}

try {
  echo divide(5, 0);
} catch(Exception $e) {
  echo "Unable to divide.";
}
?>
</pre>
