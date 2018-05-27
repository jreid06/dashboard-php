<?php
namespace my\name;

include 'backend/model/dbconnect.php';



// see "Defining Namespaces" section

class MyClass
{
    public $name = 'namespace practice';
}


const MYCONST = 1;

$a = new \my\name\MyClass;

// $c = new \my\name\MyClass; // see "Global Space" section

var_dump($a);
echo "<br>";
echo $a->name;
// var_dump($c);

$a = strlen('hi'); // see "Using namespaces: fallback to global
                   // function/constant" section

$d = namespace\MYCONST; // see "namespace operator and __NAMESPACE__
                        // constant" section
$d = __NAMESPACE__ . '\MYCONST';
echo "<br>";
echo constant($d); // see "Namespaces and dynamic language features" section
