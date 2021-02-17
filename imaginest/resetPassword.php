<?php
    require_once('./db/controlUsuari.php');
    require_once('./mailSuccessPassword.php');

    if (!empty($_GET['code']) && !empty($_GET['mail']))
    {
        $mail = filter_input(INPUT_GET, 'mail');
        $code = filter_input(INPUT_GET, 'code');

        if (!verificarCodePassMail($code, $mail))
        {
            abortarResetPass($mail);
            header("Location: index.php");
            exit();
        }
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['pass']) && isset($_POST['pass2']))
        {
            $pass = filter_input(INPUT_POST, 'pass');
            $pass2 = filter_input(INPUT_POST, 'pass2');
            $mailOculto = filter_input(INPUT_POST, 'mailOculto');

            if ($pass == $pass2)
            {
                echo $mailOculto;
                $passPOSTHash = password_hash($pass, PASSWORD_DEFAULT); 
                if (getPassExpiry($mailOculto))
                {
                    actualizarContraseña($passPOSTHash,$mailOculto);
                    enviarMailPass($mailOculto);
                    header("Location: index.php");
                }
            }
            else{
                //NO SE HACER QUE PONER A TRUE UNA VARIABLE DEL INDEX.PHP PARA QUE ME PINTE EL ERROR
                // $err3 = TRUE;
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
        <div class="cont">
            <div class="form">
                <p id="invisible"></p>
                <form method="POST" class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <img src="./img/logoImaginest.png" id="logo">
                    <h1>IMAGINEST</h1>
                    <h3>Reestablecer contraseña</h3>
                    <input id="pass" name="pass" class="pass" type="password" placeholder="Escriba la nueva contraseña:" value="<?php if(isset($pass)) echo $pass;?>"
                        autocomplete="off" autofocus required>
                    <input id="pass2" name="pass2" class="pass" type="password" placeholder="Repita la contraseña:" value="<?php if(isset($pass2)) echo $pass2;?>" autocomplete="off" required>
                    <input type="hidden" name="mailOculto" value="<?php if(isset($mail)) echo $mail;?>">
                    <button class="login" type="submit"><span>ACTUALIZAR CONTRASEÑA</span></button>
                </form>
            </div>
        </div>
</body>


</html>