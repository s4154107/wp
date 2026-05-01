<?php
$conn = mysqli_connect(
    "talsprddb02.int.its.rmit.edu.au", 
    "s4154107",                        
    "14492008Ks",            
    "s4154107"                         
);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
