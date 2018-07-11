<?php
include_once 'presentation.class.php';
View::start('Artencuentro');
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;'); // Activa la integridad referencial para esta conexión
$res=$db->prepare('SELECT * FROM obras;');
$res->execute();
$res->setFetchMode(PDO::FETCH_NAMED); // Establecemos que queremos cada fila como array asociativo

$datos = $res->fetchAll(); // Leo todos los datos de una vez

echo '<a href="a.php">hola</a>';
echo '<br>';
echo '<a href="login.php">login</a>';
echo '<br>';
echo '<a href="logout.php">logout</a>';
echo '<br>';

echo User::getLoggedUser()['nombre'];

echo '<h2>Ejemplo acceso a tabla</h2>';
// Ejemplo de mostrado de datos en forma de tabla HTML
echo "<table>";
$first=true;
foreach($datos as $game){
    if($first){
        echo "<table>";
        foreach($game as $field=>$value){
            echo "<th>$field</th>";
        }
        $first = false;
        echo "</tr>";
    }
    echo "<tr>";
    foreach($game as $field=>$value){
        if ($field == 'imagen') {
            echo "<td><img src='data:image/jpeg;base64," . base64_encode($value) . "'></td>";
        } else {
            echo "<td>$value</td>";
        }
    }
    echo "</tr>";
}
echo '</table>';

View::end();

