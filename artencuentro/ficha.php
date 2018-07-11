<?php
include_once 'presentation.class.php';

View::start('Artencuentro');
View::topnav();

$id=$_GET['id'];
$nombre=$_GET['nombre'];
$idautor=$_GET['idautor'];

$query = DB::execute_sql("SELECT obras.id,obras.titulo,obras.tipo,obras.fecha,obras.descripcion,obras.imagen FROM obras WHERE id = '$id'");
$query->setFetchMode(PDO::FETCH_NAMED);
$tabla = $query->fetchAll(); // No sé por qué se pone, pero funciona sin esto también

    echo "<table id='tabla'>";
    $first = true;

    foreach ($tabla as $row) {
        if ($first) {
            echo "<tr>";
            foreach ($row as $field => $value) {
                if ($field != 'id') {
                    echo "<th> $field </th>";
                }
            }
            $first = false;
            echo "</tr>";
        }

        echo "<tr>";
        foreach ($row as $field => $value) {
            if ($field == 'imagen') {
                echo "<td><img src='data:image/jpeg;base64," . base64_encode($value) . "'></td>";
            } else if ($field != 'id'){
                echo "<td>$value</td>";
            }
        }
        echo "<td><a href='autores.php?id=$id&nombre=$nombre&idautor=$idautor'>$nombre</a></td>";
    }
    echo "</table>";