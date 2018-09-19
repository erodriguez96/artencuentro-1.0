<?php

include_once 'presentation.class.php';

View::start('Artencuentro');
View::topnav();

if(isset($_POST['buscar'])){

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $busqueda = User::test_input($_POST["buscar"]);
    }

    $query = DB::execute_sql(" SELECT obras.idautor,obras.id,usuarios.nombre,obras.titulo,obras.fecha,obras.tipo,obras.imagen
                                    FROM obras
                                    INNER JOIN usuarios ON usuarios.id=obras.idautor
                                    WHERE obras.titulo LIKE '%$busqueda%' OR obras.tipo LIKE '%$busqueda%'
    ");

    $query->setFetchMode(PDO::FETCH_NAMED);
    $tabla = $query->fetchAll(); // No sé por qué se pone, pero funciona sin esto también

    if(count($tabla)){

        echo"<table id='tabla'>";
        $first=true;

        foreach ($tabla as $row) {
            if ($first) {
                echo "<tr>";
                foreach ($row as $field => $value) {
                    if($field != 'id'  && $field != 'idautor') {
                        echo "<th> $field </th>";
                    }
                }
                $first = false;
                echo "</tr>";
            }

            echo "<tr>";
            foreach ($row as $field => $value) {
                if($field == 'idautor' ) {
                    $idautor = $value;
                }else if ($field == 'id') {
                    $id=$value;
                }else if($field == 'nombre'){
                    $nombre=$value;
                    echo "<td><a href='autores.php?id=$id&nombre=$nombre&idautor=$idautor'>$value</a></td>";
                }else if($field == 'imagen'){
                    echo "<td><a href='ficha.php?id=$id&nombre=$nombre&idautor=$idautor'><img src='data:image/jpeg;base64,".base64_encode($value)."'></a></td>";
                }else{
                    echo "<td>$value</td>";
                }
            }

        }
        echo "</table>";

    } else {
        echo "<h1> Ningun resultado para la busqueda '$busqueda' </h1> ";
    }

} else{
    $query = DB::execute_sql('SELECT obras.idautor,obras.id,usuarios.nombre,obras.titulo,obras.fecha,obras.tipo,obras.imagen 
                                  FROM obras INNER JOIN usuarios 
                                  ON usuarios.id=obras.idautor;');
    $query->setFetchMode(PDO::FETCH_NAMED);
    $tabla = $query->fetchAll(); // No sé por qué se pone, pero funciona sin esto también

    echo"<table id='tabla'>";
    $first=true;

    foreach ($tabla as $row) {
        if ($first) {
            echo "<tr>";
            foreach ($row as $field => $value) {
                if($field != 'id' && $field != 'idautor') {
                    echo "<th> $field </th>";
                }
            }
            $first = false;
            echo "</tr>";
        }

        echo "<tr>";

        foreach ($row as $field => $value) {
            if($field == 'idautor' ) {
                $idautor = $value;
            }else if ($field == 'id') {
                $id=$value;
            }else if($field == 'nombre'){
                $nombre=$value;
                echo "<td><a href='autores.php?id=$id&nombre=$nombre&idautor=$idautor'>$value</a></td>";
            }else if($field == 'imagen'){
                echo "<td><a href='ficha.php?id=$id&nombre=$nombre&idautor=$idautor'><img src='data:image/jpeg;base64,".base64_encode($value)."'></a></td>";
            }else{
                echo "<td>$value</td>";
            }
        }
    }
    echo "</table>";
}