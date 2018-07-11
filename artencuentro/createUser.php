<?php
include_once 'presentation.class.php';

View::start('Artencuentro');

View::topnav();

if(isset($_POST['submit'])){
    $id=$_POST['id'];
    $cuenta=$_POST['cuenta'];
    $clave=$_POST['clave'];
    $nombre=$_POST['nombre'];
    $tipo=$_POST['tipo'];
    $poblacion=$_POST['poblacion'];
    $direccion=$_POST['direccion'];
    $telefono=$_POST['telefono'];

    echo $id;
    echo $cuenta;
    echo $clave;
    echo $nombre;
    echo $tipo;
    echo $poblacion;
    echo $direccion;
    echo $telefono;

    //aqui hacer comprobaciones pertinentes sobre el usuario en la base de datos y añadirlo si
    // todo esta en orden (insert into table valores)
    header('Location: index.php');
}

// id	cuenta	clave	nombre	tipo	poblacion	direccion	telefono

echo '
    <div class="formulario">
        <form method="post">
            <input type=text name="id" value="" placeholder="introduzca id de usuario" required><br>
            <input type=text name="cuenta" value="" placeholder="introduzca nombre de cuenta" required><br>
            <input type=password name="clave" value="" placeholder="contraseña" required><br>
            <input type=text name="nombre" value="" placeholder="nombre de usuario" required><br>
            <input type=text name="tipo" value="" placeholder="tipo de cuenta (1-admin, 2-autor, 3-empresa)" required><br>
            <input type=text name="poblacion" value="" placeholder="Población" required><br>
            <input type=text name="direccion" value="" placeholder="Dirección" required><br>
            <input type=text name="telefono" value="" placeholder="telefono" required><br>
            <input type="submit" value="Enviar" name="submit">
        </form>
    </div>
';