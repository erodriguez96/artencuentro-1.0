<?php

include_once 'presentation.class.php';

View::start('Artencuentro');
View::topnav();

$id=$_GET['id'];
$nombre=$_GET['nombre'];
$idautor=$_GET['idautor'];
$actual = User::getLoggedUser()['id'];

$query = DB::execute_sql("SELECT usuarios.nombre,obras.id,obras.idautor,obras.titulo,obras.imagen
                                FROM obras INNER JOIN usuarios ON obras.idautor = usuarios.id
                                WHERE '$idautor'=idautor;");
$query->setFetchMode(PDO::FETCH_NAMED);
$tabla = $query->fetchAll(); // No sé por qué se pone, pero funciona sin esto también


if($actual == $idautor){
    echo "<table id='tabla'>";
    $first = true;
    foreach ($tabla as $row) {

        if ($first) {
            echo "<tr>";
            foreach ($row as $field => $value) {
                if ($field != 'idautor' && $field != 'id' && $field != 'nombre') {
                    echo "<th> $field </th>";
                }
            }
            $first = false;
            echo "</tr>";
        }

        foreach ($row as $field => $value) {
            if ($field == 'id') {
                $id = $value;
                $cuestion = DB::execute_sql("SELECT * FROM megusta WHERE idobra = $id AND idusuario = $actual");
                $cuestion->setFetchMode(PDO::FETCH_NAMED);
                $cuestion = $cuestion->fetchAll();

                $obra = count($cuestion)==1;
                echo count($cuestion);
                if($obra){
                    $llamada = 'noMeGusta';
                } else{
                    $llamada = 'meGusta';
                }

            } else if ($field == 'imagen') {
                $td_img = "<td><a href='ficha.php?id=$id&nombre=$nombre&idautor=$idautor'><img src='data:image/jpeg;base64," . base64_encode($value) . "'></a></td>";
            } else if ($field == 'titulo') {
                $titulo = $value;
                $td_titulo = "<td>$titulo</td>";
            }
        }
        $td_edit = "<td><a href='metodos_autor.php?value=editar&id=$id'>Editar</a></td>";
        $td_megusta = "<td><a id='button$id' class='$llamada' onclick='$llamada($id)'></td>";
        $td_del = "<td><button type='button' onclick='borra($id,\"eliminar\",\"$titulo\")'> Eliminar </button></td>";
        echo "<tr id=$id>$td_titulo $td_img $td_megusta $td_edit $td_del</tr>";
    }
    echo "<tr><th colspan='5'><a href='metodos_autor.php?value=añadir&id=$idautor'> Añadir Obra </a></th></tr>";
    echo "</table>";

}else{
    echo "<table id='tabla'>";
    $first = true;

    foreach ($tabla as $row) {

        if ($first) {
            echo "<tr>";
            foreach ($row as $field => $value) {
                if($field == 'nombre'){
                    echo "<tr><th colspan='2'> $value </th></tr>";
                }
                if ($field != 'idautor' && $field != 'id' && $field != 'nombre') {
                    echo "<th> $field </th>";
                }
            }
            $first = false;
            echo "</tr>";
        }

        echo "<tr>";
        foreach ($row as $field => $value) {
            if ($field == 'id') {
                $id = $value;
            }  else if($field == 'imagen'){
                echo "<td><a href='ficha.php?id=$id&nombre=$nombre&idautor=$idautor'><img src='data:image/jpeg;base64,".base64_encode($value)."'></a></td>";
            }else if ($field != 'idautor' && $field != 'id' && $field != 'nombre'){
                echo "<td>$value</td>";
            }
        }
    }
    echo "</table>";
}













