<?php

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require_once('logout.php');
        header('location: index.php');
        exit();
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
        <?php
            session_start();            
            echo "<p class=bienvenido>Bienvenido " . $_SESSION['usuari'] . "</p>";
        ?>
        <div class="cont2">
            <form method="POST" class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">  
                <button class="login" type="submit"><span>CERRAR SESIÓN</span></button>
            </form>
        </div>
    </div>
</body>

</html>