<?php

$showAlert = false;
$showError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'D://xampp//htdocs//PHP-Learning//Login-System/parts//dbConnect.php';


    $email = $_POST["useremail"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    // check whether this email already exists
    $existSql = "SELECT * FROM `users` where email = '$email'";

    $result = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($result);

    if ($numExistRows > 0) {
        $showError = "Email already registerd";

    } else {

        if (($email == "" && $username == "")) {
            $showError = "please provide both email and full name";
        } 
        
        else if (($email != "" && $username != "" && $password == $cpassword)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO `users` (`email`, `username`, `password`, `createdAt`) VALUES ('$email', '$username', '$hash', current_timestamp())";

            $result = mysqli_query($conn, $sql);

            if ($result) {
                $showAlert = true;
            }
        } 
        
        else {
            $showError = "Password do not match.";
        }
    }

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <?php require 'D://xampp//htdocs//PHP-Learning//Login-System/parts//nav.php' ?>

    <?php

    if ($showAlert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                 <strong>Success! </strong> Your account is created please login.
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>';
    }


    if ($showError != "") {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                 <strong>Error! </strong>' . $showError .
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>';
    }
    ?>


    <div class="container bg-body-secondary p-4 mt-5 rounded">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h1 class="text-center">Signup to our website</h1>

                <form action="http://localhost/PHP-Learning/Login-System/signup.php" method="post">

                    <div class="mb-3">
                        <label for="useremail" class="form-label">Email</label>
                        <input type="email" maxlength="32" class="form-control" id="useremail" name="useremail">
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Full Name</label>
                        <input type="text" maxlength="20" class="form-control" id="username" name="username">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" maxlength="20" class="form-control" id="password" name="password">
                    </div>

                    <div class="mb-3">
                        <label for="cpassword" class="form-label">Confirm Password</label>
                        <input type="password" maxlength="20" class="form-control" id="cpassword" name="cpassword">
                        <div class="form-text">Make sure to type the same password</div>
                    </div>

                    <div style="display: flex; justify-content: center;">
                        <button type="submit" class="btn btn-success">Sign Up</button>
                    </div>

                </form>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>