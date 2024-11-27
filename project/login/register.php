<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <?php
    session_start();
    require_once '../databases/connect.php';
    require_once '../databases/database.class.php';
    require_once '../functions/functions.php';

    $db = new Database();
    $user = new User($db);
    $array = $user->get_section();

    $emailErr = $passwordErr = '';
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = clean_input(($_POST['email']));
        $password = clean_input(($_POST['password']));
        $ln = clean_input(($_POST['last_name']));
        $fn = clean_input(($_POST['first_name']));
        $mn = clean_input(($_POST['middle_name']));
        $section = clean_input(($_POST['section']));

        if(empty($email)) {
            $emailErr = "Email is Required";
        }
        if(empty($password)) {
            $passwordErr = "Password is Required";
        }
        if(empty($mn)) {
            $mn = null;
        }
        if(empty($section)) {
            $section = null;
        }

        if(empty($emailErr) && empty($passwordErr)) {
            if ($user->register($email, $password, $ln, $fn, $mn, $section)) {
                $_SESSION['success'] = 'Account created successfully! You can now log in.';
                header('Location: login.php');
                exit();
            }
        }
    }
    ?>

    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <form method="post">
        <label for="Email">Email</label>
        <input type="text" name="email" id="email"><br>

        <label for="Password">Password</label>
        <input type="text" name="password" id="password"><br>

        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name"><br>

        <label for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name"><br>

        <label for="middle_name">Middle Name</label>
        <input type="text" name="middle_name" id="middle_name"><br>

        <label for="section">Section</label>
        <select name="section" id="section">
            <option value="">Section</option>
            <?php foreach($array as $arr) {?>
                <option value="<?=$arr['id']?>"><?=$arr['name']?></option>
            <?php
            }
            ?>
        </select>
        <br>
        <button type="submit" id="register" name="register">Register</button>
        <?php
        if (!empty($emailErr)) {
        ?>
            <p class="error"><?= $emailErr ?></p>
        <?php
        }
        if (!empty($passwordErr)) {
        ?>
            <p class="error"><?= $passwordErr ?></p>
        <?php
        }
        ?>
        
    </form>
</body>
</html>