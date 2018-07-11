<?php
include_once 'presentation.class.php';

View::start('Artencuentro');
View::topnav();

$id = $_GET['id'];
$tipo = $_GET['tipo'];

if(User::getLoggedUser()['id'] == $id) {
    //propuestas si es un autor
    if($tipo == 2){

        $query = DB::execute_sql("SELECT propuestas.id,propuestas.idempresa,usuarios.nombre,propuestas.idautor,propuestas.hora,propuestas.descripcion,propuestas.presupuesto
                                  FROM propuestas INNER JOIN usuarios
                                  ON propuestas.idempresa = usuarios.id
                                  WHERE idautor='$id';");

        $query->setFetchMode(PDO::FETCH_NAMED);
        $tabla = $query->fetchAll();

        echo "<table id='tabla'>";
        $first = true;

        if(count($tabla)){
            foreach ($tabla as $row) {
                if ($first) {
                    echo "<tr>";
                    foreach ($row as $field => $value) {
                        if($field == 'nombre'){
                            echo "<th> Empresa </th>";
                        } else if ($field != 'idautor' && $field != 'id' && $field != 'idempresa') {
                            echo "<th> $field </th>";
                        }
                    }
                    $first = false;
                    echo "</tr>";
                }

                echo "<tr>";
                foreach ($row as $field => $value) {
                    if ($field == 'hora'){
                        $fecha = gmdate('Y-m-d H:i:s', $value);
                        echo "<td> $fecha </td>";
                    }else if($field == 'id'){
                        $idpropuesta = $value;
                    }else if($field == 'idempresa'){
                        $idempresa = $value;
                    } else if ($field != 'idautor'){
                        echo "<td>$value</td>";
                    }
                }
                echo "<td><a href='mensajes.php?idpropuesta=$idpropuesta&idactual=$id&idotro=$idempresa'> Ver Mensajes </a> </td>";
            }
            echo "</table>";
        }else{
            echo "<h1> Ninguna propuesta para usted. </h1>";
        }

    //propuestas si es una empresa.
    }else if($tipo == 3){
        $query = DB::execute_sql("SELECT propuestas.id,propuestas.idautor,usuarios.nombre,propuestas.hora,propuestas.descripcion,propuestas.presupuesto
                                        FROM propuestas INNER JOIN usuarios
                                        ON propuestas.idautor = usuarios.id
                                        WHERE idempresa = '$id';");

        $query->setFetchMode(PDO::FETCH_NAMED);
        $tabla = $query->fetchAll();

        echo "<table id='tabla'>";
        $first = true;

        if(count($tabla)){
            foreach ($tabla as $row) {
                if ($first) {
                    echo "<tr>";
                    foreach ($row as $field => $value) {
                        if($field == 'nombre'){
                            echo "<th> Autor </th>";
                        } else if ($field != 'id' && $field != 'idempresa' && $field != 'idautor') {
                            echo "<th> $field </th>";
                        }
                    }
                    $first = false;
                    echo "</tr>";
                }

                echo "<tr>";
                foreach ($row as $field => $value) {
                    if ($field == 'hora'){
                        $fecha = gmdate('Y-m-d H:i:s', $value);
                        echo "<td> $fecha </td>";
                    }else if($field == 'id'){
                        $idpropuesta = $value;
                    }else if($field == 'idautor'){
                        $idautor = $value;
                    }else{
                        echo "<td>$value</td>";
                    }
                }
                echo "<td><a href='mensajes.php?idpropuesta=$idpropuesta&idactual=$id&idotro=$idautor'> Ver Mensajes </a> </td>";
            }
            echo "</table>";
        }else{
            echo "<h1> Ninguna propuesta realizada. </h1>";
        }

    }

} else{
    echo"<h1> Este usuario NO eres tu, pillin </h1>";
}
