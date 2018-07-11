<!doctype html>
<html>
<head>
<meta charset="utf-8">
<style type="text/css">
body{font-family: Monospace;}
table, th, td {	border-collapse: collapse;border: 1px solid;padding: 2px;}
.numero {text-align: right}
tr:nth-child(odd) {background-color: #f0f0c0;}
th {background-color: #c0e0e0;}
</style>
<title>Todo</title>
</head>
<body>
<?php
//$PATH = $_SERVER['DOCUMENT_ROOT'];
$PATH = "C:/Users/eduardo/Desktop/artencuentro/";
$db = new PDO("sqlite:$PATH/datos.db");
$db->exec('PRAGMA foreign_keys = ON;'); //Activa la integridad referencial para esta conexión
echo "<h1>Datos en las tablas de \"sqlite:$PATH/datos.db\"</h1>";
Function all($table){
    global $db;
    $res=$db->prepare("SELECT * FROM $table;");
    $res->execute();
    $res->setFetchMode(PDO::FETCH_NAMED);
    $all=$res->fetchAll();
    echo "<h2>Tabla '$table'</h2>";
    echo "<table>";
    foreach($all as $id =>$row){
        if($id == 0){
            echo "<tr>";
            foreach($row as $field=>$value){
                echo "<th>$field</th>";
            }
            echo "</tr>";
        }
        echo "<tr>";
        foreach ($row as $field => $value) {
            $class = '';
            if( $value > 0) {
                $class ='class="numero"';
            }
            if ($field == 'hora' && $value > 0) {
                echo "<td $class>" . date("Y-m-d H:i:s",$value) . "</td>";
            } else if ($field == 'imagen') {
                echo "<td $class><img src='data:image/jpeg;base64,/" . base64_encode($value) . "'></td>";
            } else {
                echo "<td $class>$value</td>";
            }
        }
        echo "</tr>";
    }
    echo '</table>';
}
all('usuarios');
all('obras');
all('propuestas');
all('mensajes');
all('megusta');
?>
</body>
</html>
