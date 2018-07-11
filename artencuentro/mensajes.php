<?php
include_once 'presentation.class.php';

View::start('Artencuentro');

View::topnav();

$idpropuesta=$_GET['idpropuesta'];
$idactual=$_GET['idactual'];
$idotro=$_GET['idotro'];

if(isset($_POST['enviar'])){
    $mensaje = $_POST['mensaje'];
    $timestamp = time(date('Y-m-d G:i:s'));

    $query = DB::execute_sql("INSERT INTO mensajes (idpropuesta,idusuario,hora,mensaje) VALUES ('$idpropuesta','$idactual','$timestamp','$mensaje');");
    $query = DB::execute_sql("SELECT * FROM mensajes");
    $query->setFetchMode(PDO::FETCH_NAMED);

    $tabla = $query->fetchAll();
}

if(User::getLoggedUser()['id'] == $idactual){

    $query = DB::execute_sql("SELECT mensajes.hora,mensajes.mensaje,usuarios.nombre
                                    FROM mensajes
                                    INNER JOIN usuarios
                                    ON mensajes.idusuario = usuarios.id
                                    WHERE idpropuesta = '$idpropuesta' AND idusuario = '$idactual' OR idusuario = '$idotro'
                                    ORDER BY hora;");
    $query->setFetchMode(PDO::FETCH_NAMED);
    $tabla = $query->fetchAll();

    echo "<table id='tabla'>";
    $first = true;

    if(count($tabla)) {
        foreach ($tabla as $row) {
            if ($first) {
                echo "<tr>";
                foreach ($row as $field => $value) {
                    if($field == 'nombre'){
                        echo "<th> Remitente </th>";
                    }else {
                        echo "<th> $field </th>";
                    }
                }
                $first = false;
                echo "</tr>";
            }

            echo "<tr>";
            foreach ($row as $field => $value) {
                if ($field == 'hora') {
                    $fecha = gmdate('Y-m-d H:i:s', $value);
                    echo "<td> $fecha </td>";
                } else {
                    echo "<td> $value </td>";
                }
            }
        }

        echo '<tr><td><form method="post" class="formulario">
                    <input type=textarea name="mensaje" value="" placeholder="Escriba su mensaje"><br>
                    <td><input type="submit" value="Enviar" name="enviar"></td>
                </form></td></tr>';
        echo "</table>";

    }

}else{

}
