<?php

$name = $_POST['myname'];
$email = $_POST['myemail'];
$gender = $_POST['mygender'];
$age = $_POST['myage'];
$car = $_POST['mycar'];

    if (!empty($name) || !empty($email) || !empty($gender) || !empty($age) 
         || !empty($car) )
     {
         $host ="localhost";
         $dbUsername ="root";
         $dbPassword ="";
         $dbname ="inform"; 

         //create connection
         $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

          if (mysqli_connect_error())
            {
           die('Connect Error('.mysqli_connect_errno().')'. mysqli_connect_error());
            }
          else
             {
           $SELECT = "SELECT NAME FROM REGISTER WHERE NAME = ? Limit 1";
	   $INSERT = "INSERT INTO REGISTER(NAME,EMAIL,GENDER,AGE,CAR) VALUES (?,?,?,?,?)";

           //prepare statement
           $stmt = $conn->prepare($SELECT);
           $stmt->bind_param("s",$name);
           $stmt->execute();
           $stmt->bind_result($name);
           $stmt->store_result();
           $rnum = $stmt->num_rows;

               if ($rnum==0)
                  {
                 $stmt->close();
                 $stmt = $conn->prepare($INSERT);
                 $stmt->bind_param("sssis",$name,$email,
                     $gender,$age,$car);
 		 $stmt->execute();
                  echo "New Record inserted successfully";
                   }
               else
                {
                  echo "Someone Alreaady Registered throught this name";
                }
               $stmt->close();
               $conn->close(); 
             }
     }
     else
      {
        echo "All field are Rerquired"; 
        die();
      }


?>