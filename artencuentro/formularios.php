<?php
include_once 'presentation.class.php';

View::start('Artencuentro');

View::topnav();

$idobra=$_GET['id'];
$idautor=$_GET['idautor'];

if(User::getLoggedUser()['id'] == $idautor){

    $query = DB::execute_sql("SELECT titulo,tipo,descripcion FROM obras WHERE id='$idobra'");
    $query->setFetchMode(PDO::FETCH_NAMED);
    $tabla = $query->fetchAll();

    print_r($tabla);




    echo '
    <div class="formulario">
        <form method="post">
            <input type=text name="titulo" value="" placeholder="Titulo de la obra"><br>
            <input type=text name="tipo" value="" placeholder="tipo de la obra"><br>
            <input type=textarea name="descripcion" value="" placeholder="descripcion de la obra"><br>
            <input type="submit" value="Enviar">
        </form>
    </div>
';

}