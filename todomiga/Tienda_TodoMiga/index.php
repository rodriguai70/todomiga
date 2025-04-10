<?php

spl_autoload_register(function ($clase) {
    include  $clase . '.php';
});


//if (isset($_POST['iniciar'])) {

    $opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
    
    //$baseDatos = $_POST['bd'];
    $servidor = "localhost";
    $baseDatos = "todomiga";
    //$dns = "mysql:host=" . $_POST['servidor'] . ";dbname=" . $_POST['bd'];
    $dns = "mysql:host=$servidor;dbname=$baseDatos";
    //$usuario = $_POST['usuario'];
    //$contraseña = $_POST['contraseña'];
    $usuario = "root";
    $contrasena = "";
   
    try {
        $todomiga = new PDO($dns, $usuario, $contrasena, $opc);
        

        
        $config = new Configuracion();
       // $config->setServidor($_POST['servidor']);
       $config->setServidor("localhost");
       // $config->setBaseDatos($_POST['bd']);
       $config->setBaseDatos("todomiga");
        //$config->setUsuario($_POST['usuario']);
        $config->setUsuario("root");
        //$config->setPassword($_POST['password']);
        $config->setPassword("");
        session_start();
        // Guarda en la sesión un objeto de la clase Configuracion
        $_SESSION['configura'] = $config->serialize($config);

        header("Location: login.php");
    } catch (PDOException $e) {
        $error = "Datos erróneos de conexión";
    }
//}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Configuración</title>
    <link href="tienda.css" rel="stylesheet" type="text/css">
</head>

<body>
<div id='login'>
        <form action='index.php' method='post'>
            <fieldset style="height: 270px;">
                <legend>Configuración inicial</legend>
                <div><span class='error'><?php echo $error; ?></span></div>
                <div class='campo'>
                    <label for='servidor'>Servidor:</label><br />
                   
                    <input type='text' name='servidor' id='servidor' maxlength="50" required="true" /><br />
                </div>
                <div class='campo'>
                    <label for='bd'>Base de datos:</label><br />
                    <input type='text' name='bd' id='bd' maxlength="50" required="true" /><br />
                </div>
                <div class='campo'>
                    <label for='usuario'>Usuario:</label><br />
                    <input type='text' name='usuario' id='usuario' maxlength="50" required="true" /><br />
                </div>
                <div class='campo'>
                    <label for='password'>Password:</label><br />
                    <input type='password' name='password' id='password' maxlength="50" /><br />
                </div>

                <div class='campo'>
                    <input type='submit' name='iniciar' value='Iniciar' />
                </div>
            </fieldset>
        </form>
    </div>
</body>

</html>