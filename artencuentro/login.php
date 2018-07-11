<?php
include_once 'presentation.class.php';

View::start('Artencuentro');

View::topnav();

$control=$_GET['value'];

if(isset($_POST['enviar'])){
    $user = $password = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = User::test_input($_POST["user"]);
        $password = User::test_input($_POST["password"]);
        if (User::login($user, $password)){
            header('Location: index.php');
        } else{
            echo "<h2> El usuario o la contraseña no coinciden. </h2>";
        }
    }
}


if($control == 0){
    User::logout();
    header('Location: index.php');
} else{
    echo '
    <div class="formulario">
        <form method="post"> <!-- action="'. 'htmlspecialchars($_SERVER[PHP_SELF]) '.'"-->
            <input type=text name="user" value="" placeholder="username"><br>
            <input type=password name="password" value="" placeholder="contraseña"><br>
            <input type="submit" value="Enviar" name="enviar">
        </form>
    </div>
';
}


