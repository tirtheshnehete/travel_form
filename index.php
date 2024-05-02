<?php
$insert=false;
if(isset($_POST['submit'])){ // Changed to check if the form has been submitted
    //connection variables
    $server='localhost';
    $username='root';
    $password='';
    $database='db1'; // Added database name

    //create a database connection
    $conn= mysqli_connect($server,$username,$password,$database);

    //check for connection success
    if(!$conn){
        die("connection to this database failed due to".mysqli_connect_error()); 
    }
    //echo"success connecting to db";


    //collect post variables
    $name=$_POST['name'];
    $gender=$_POST['gender'];
    $age=$_POST['age'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    // Modified query to use prepared statement
    $sql ="INSERT INTO user (name, age, gender, email, phone, date) 
    VALUES (?, ?, ?, ?, ?, current_timestamp())";

   // echo $sql;

   //prepare and bind the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisss", $name, $age, $gender, $email, $phone); // "sisss" indicates data types of the parameters

   //execute the query
    if($stmt->execute()){
        //flag for successful insertion
        $insert=true;
    }
    else{
        echo "ERR " . $sql . "<br>" . $conn->error;
    }

    //close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Travel Form</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="form">
        <div class="container">
            <h1>Welcome to Travel form</h1>
            <p>Enter your details and submit this form to confirm your participation details</p>

            <form action="index.php" method="post">
                <input type="text" class="inp" name="name" placeholder="Enter your name"> <!-- Added name attribute -->
                <input type="text" class="inp" name="age" placeholder="Enter your age"> <!-- Added name attribute -->
                <input type="text" class="inp" name="gender" placeholder="Enter your gender"> <!-- Added name attribute -->
                <input type="email" class="inp" name="email" placeholder="Enter your email"> <!-- Added name attribute -->
                <input type="text" class="inp" name="phone" placeholder="Enter your phone"> <!-- Added name attribute -->
                <button type="submit" class="btn" name="submit">Submit</button> <!-- Added name attribute and type attribute -->
            </form>

            <?php
            if($insert==true){
                echo "<p class='submitmsg'>Thanks for submitting the form.</p>";
            }
            ?>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>
