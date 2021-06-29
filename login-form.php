<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN FORM</title>
</head>

<body>
    <h1>LOGIN</h1>

    <?php
    define("filepath", "user-info.txt");

    $useName = $password = "";
    $userNameErr = $passwordErr = "";
    $successMessage = $errorMessage = "";
    $flag = false;
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $userName = $_POST['userName'];
        $password = $_POST['password'];

        if (empty($userName)) {
            $userNameErr = "User name cannot be empty!";
            $flag = true;
        }
        if (empty($password)) {
            $passwordErr = "password cannot be empty!";
            $flag = true;
        }
        if (!$flag) {
            $userName = test_input($userName);
            $password = test_input($password);

            validatePass($userName, $password);
            // $result1 = read($data_decode);
            /*if($result1) {
                        $successMessage = "Login Successfull.";
                    }
                    else{
                        $errorMessage = "Error while logging in!";
                    }*/
        }
    }


    function test_input($data)
    {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <label for="userName">Username<span style="color : red;">* </span>:</label>
        <input type="text" id="userName" name="userName">
        <span style="color : red;"><?php echo $userNameErr; ?></span> <br> <br>

        <label for="password">Password<span style="color : red;">* </span>:</label>
        <input type="password" id="password" name="password">

        <span style="color : red;"><?php echo $passwordErr; ?></span> <br> <br>

        <input class="register_button" type="submit" value="LOGIN">
    </form>
    <span style="color : green"><?php echo $successMessage; ?> </span>
    <span style="color : red"><?php echo $errorMessage; ?> </span>
    <p>Don't have an account? <a href="signup.php">Register here!</a>
    </p>

    <?php
    $fileData = read();
    $fileDataExplode = explode("\n", $fileData);

    /*echo "<ol>";
        for($i = 0; $i < count($fileDataExplode) - 1; $i++) {
            $candidate = json_decode($fileDataExplode[$i]);
        echo "<li>" . "username: " . $candidate->$userName . "password: " . $candidate->$password . "</li>";
        }
        echo "</ol>";*/


    function read()
    {
        $resource = fopen(filepath, "r");
        $fz = filesize(filepath);
        $fr = "";

        //echo fread($resource, filesize(filepath));


        if ($fz > 0) {
            $fr = fread($resource, $fz);
        }
        // echo $fr;
        fclose($resource);
        return $fr;
    }

    function validatePass($username, $password)
    {
        $DBdata = read();

        $userData = json_decode($DBdata, true);

        foreach ($userData as $items) {
            if (strcmp($items['username'], $username)) {
                echo $items['password'];
            }
        }
    }
    ?>

</body>

</html>