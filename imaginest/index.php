<?php
    require_once('./db/controlUsuari.php');
    require_once('./resetPasswordSend.php');
    
    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['user']) && isset($_POST['pass'])){
            //Protección ante XSS
            $userPOST = filter_input(INPUT_POST, 'user');
            $passPOST = filter_input(INPUT_POST, 'pass');
            $passHash = getHashPass($userPOST);

            //$usuari = verificaUsuari($userPOST);
            if(verificaUsuari($userPOST) && password_verify($passPOST,$passHash[0])){
                session_start();
                if (!empty($userPOST)) $_SESSION['usuari'] = $userPOST;
                header("Location: home.php");
                exit();
            }else{
                $err = TRUE;
                $user = $userPOST;
            }
            $err = TRUE;
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
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>

<body>
    <div id="pagewrapper">
        <div class="cont">
            <div class="form">
                <form method="POST" class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <img src="./img/logoImaginest.png" id="logo">
                    <h1>IMAGINEST</h1>
                    <h3>Iniciar sesión</h3>
                    <input id="user" name="user" class="user" type="text" placeholder="Usuario / Correo electrónico" value="<?php if(isset($user)) echo $user;?>"
                        autocomplete="off" autofocus required>
                    <input id="pass" name="pass" class="pass" type="password" placeholder="Contraseña" autocomplete="off" required>
                    <button class="login" type="submit"><span>INICIAR SESIÓN</span></button>
                    <?php 
                        if(isset($err) && $err == TRUE){
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Revisa el correo electrónico y/o la contraseña. Tiene su cuenta activada?
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        }
                        if(isset($err2) && $err2 == TRUE){
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Correo no registrado!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        }
                        if(isset($err3) && $err3 == TRUE){
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Las contraseñas no coinciden
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        }
                        if(isset($msg) && $msg == TRUE){
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            Enlace para reestablecer contraseña enviado a correo electrónico
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        }
                        if(isset($msg2) && $msg2 == TRUE){
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            Usuario creado correctamente! Active su cuenta
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        }
                        if(isset($msg3) && $msg3 == TRUE){
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            Cuenta activada correctamente! Ya puede iniciar sesión
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        }
                    ?>
                </form>
                <a class="open-button" onclick="openForm()">Has olvidado la contraseña?</a>
                <div class="form-popup" id="myForm">
                    <form method="POST" class="form-container">
                        <h3>Recuperar contraseña</h3>
                        <input type="text" placeholder="Introduce tu correo electronico:" name="email" required>
                        <button type="submit" class="enviarRecuperar">Enviar</button>
                        <button type="button" class="cerrarRecuperar" onclick="closeForm()">Cerrar</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="cont2">
            <h3>¿No tienes cuenta?</h3>
            <button class="register"><a href="register.php" class="aRegister">REGISTRARSE</a></button>
        </div>
    </div>

    <script>
        function openForm() {
        document.getElementById("myForm").style.display = "block";
        }

        function closeForm() {
        document.getElementById("myForm").style.display = "none";
        }
    </script>
</body>


</html>