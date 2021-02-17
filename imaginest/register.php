<?php
    require_once('./db/controlUsuari.php');
    require_once('./mail.php');

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['user']) && isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['verifyPass'])){

            //Protección ante XSS
            $userPOST = filter_input(INPUT_POST, 'user');
            $emailPOST = filter_input(INPUT_POST, 'email');
            $firstNamePOST = filter_input(INPUT_POST, 'firstName');
            $lastNamePOST = filter_input(INPUT_POST, 'lastName');
            $passPOST = filter_input(INPUT_POST, 'pass');
            $verifyPassPOST = filter_input(INPUT_POST, 'verifyPass');
            $passPOSTHash = password_hash($passPOST, PASSWORD_DEFAULT); 

            if (existeixUsername($userPOST)) $error = "Este usuario ya existe.";
            else if (existeixEmail($emailPOST)) $error = "Este email ya existe.";
            else if ($passPOST!=$verifyPassPOST) $error = "Las contraseñas no coinciden.";
            else {
                registrarUsuari($userPOST, $emailPOST, $firstNamePOST, $lastNamePOST, $passPOSTHash);
                $activationCode=getActivationCode($userPOST);
                enviarMail($emailPOST, $activationCode[0]);
                header("Location: index.php");
                exit();
            }
        }
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <title>IMAGINEST - TU RED SOCIAL</title>
    <link rel="stylesheet" type="text/css" href="./css/main.css" />
    <link rel="icon" href="./img/logoImaginest.png"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <div id="pagewrapper">
        <div class="contRegister">
            <div class="form">
                <form method="POST" class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <img src="./img/logoImaginest.png" id="logo">
                    <h1>IMAGINEST</h1> 
                    <h3>Crear cuenta</h3>   
                    <?php 
                        if(isset($error)){
                            echo "<img class=fary src=./img/elfary3.jpg></img>";
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            '. $error .'
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        }
                    ?>
                    <input id="user" name="user" class="user" type="text" placeholder="Usuario" value="<?php if(isset($user)) echo $user;?>"
                        autocomplete="off" autofocus required>
                    <input id="email" name="email" class="email" type="email" placeholder="Correo electrónico" value="<?php if(isset($user)) echo $user;?>"
                        autocomplete="off" required>
                    <input id="firstName" name="firstName" class="firstName" type="text" placeholder="Nombre" value="<?php if(isset($user)) echo $user;?>"
                        autocomplete="off">
                    <input id="lastName" name="lastName" class="lastName" type="text" placeholder="Apellido/s" value="<?php if(isset($user)) echo $user;?>"
                        autocomplete="off">
                    <input id="pass" name="pass" class="pass" type="password" placeholder="Contraseña" autocomplete="off" required>
                    <input id="verifyPass" name="verifyPass" class="pass" type="password" placeholder="Repita la contraseña" autocomplete="off" required>
                    <button class="login" type="submit"><span>CREAR CUENTA</span></button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>