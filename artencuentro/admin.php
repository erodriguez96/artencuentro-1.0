<?php
include_once 'presentation.class.php';

View::start('Artencuentro');
View::topnav();

$query = DB::execute_sql('SELECT id,cuenta,nombre FROM usuarios');
$query->setFetchMode(PDO::FETCH_NAMED);
$tabla = $query->fetchAll(); // No sé por qué se pone, pero funciona sin esto también

echo"<table id='tabla'>";
$first=true;

foreach ($tabla as $row) {
    if ($first) {
        echo "<tr>";
        foreach ($row as $field => $value) {
            if($field == 'nombre'){
                echo "<th> $field </th>";
            }
        }
        $first = false;
        echo "</tr>";
    }

    echo "<tr>";
    foreach ($row as $field => $value) {
        if($field != 'id' && $field != 'cuenta'){
            echo "<td> $value </td>";
        }
    }
    echo "<td> <a href='index.php'>Editar</a> <a href='index.php'>Eliminar</a> </td>";
}
echo "<tr><th colspan='2'> <a href='createUser.php'>Crear Usuario</a> </th></tr>";
echo "</table>";

View::end();