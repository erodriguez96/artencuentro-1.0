<?php

include_once 'presentation.class.php';

$id = $_GET['id'];
$met = $_GET['value'];

$id2=User::getLoggedUser()['id'];
$nombre=User::getLoggedUser()['nombre'];
$idautor=User::getLoggedUser()['id'];



if(isset($_POST['metodo'])){
    if($_POST['metodo'] == "meGusta"){
        db::execute_sql("INSERT INTO megusta (idobra,idusuario) VALUES (?,?)", array($_POST['idobra'],$id2));
    } else{
        db::execute_sql("DELETE FROM megusta WHERE idobra = ? AND idusuario = ?", array($_POST['idobra'],$id2));
    }

    $numerolikes = db::execute_sql("SELECT count(idobra) FROM megusta WHERE idobra=?", array($_POST['idobra']));
    $numerolikes -> setFetchMode(PDO::FETCH_NUM);
    $numerolikes = $numerolikes->fetchAll();
    echo $numerolikes[0][0];
//    header("Location: autores.php?id=$id2&nombre=$nombre&idautor=$idautor");
}

if(isset($_POST['Editar'])){
    $titulo = $_POST['titulo'];
    $tipo = $_POST['tipo'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];
    db::execute_sql("UPDATE obras SET titulo=?, tipo=?, fecha = ?, descripcion=? WHERE id=?",array($titulo,$tipo,$fecha,$descripcion,$id));
    header("Location: autores.php?id=$id2&nombre=$nombre&idautor=$idautor");
}

if(isset($_POST['Añadir'])){

    $titulo = $_POST['titulo'];
    $tipo = $_POST['tipo'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];

    $image = file_get_contents($_FILES['image']['tmp_name']);

    db::execute_sql("INSERT INTO obras(idautor, titulo, tipo, fecha, descripcion,imagen) VALUES (?,?,?,?,?,?)",array($id,$titulo,$tipo,$fecha,$descripcion,$image));
    header("Location: autores.php?id=$id2&nombre=$nombre&idautor=$idautor");
}



switch($met){
    case "añadir"; //añadir
        metodos_autor::añadir($id);
        break;
    case "eliminar"; //eliminar
        metodos_autor::eliminar($id);
        break;
    case "editar"; //editar
        metodos_autor::editar($id);
        break;
}

class metodos_autor{
    public static function eliminar($id){

        $elimina = db::execute_sql("DELETE FROM obras WHERE id=?",array($id));

        if($elimina){
            echo "eliminado";
        }else{
            echo "no se puede eliminar";
        }
        exit();
    }

    public static function editar($id){

        View::start('Artencuentro');
        View::topnav();

        $obra = db::execute_sql('SELECT * FROM obras WHERE id=?', array($id));
        $obra->setFetchMode(PDO::FETCH_NAMED);
        $obra = $obra->fetchAll();
        $obra = $obra[0];
        echo '
            <div id="form">
                <form name="myForm" method="POST" class="formulario" onsubmit="return validation()">
                    <a>titulo</a> <input type="text" name="titulo" value="'.$obra['titulo'].'" placeholder="..." required><br>
                    <a>tipo</a> <input type="text" name="tipo" value="'.$obra['tipo'].'" placeholder="..." required><br>
                    <a>fecha</a> <input type="text" name="fecha" value="'.$obra['fecha'].'" placeholder="..." required><br>
                    <a>descripcion</a> <input type="text" name="descripcion" value="'.$obra['descripcion'].'" placeholder="..." required><br>
                    <input type="submit" value="Aceptar" name="Editar">
                    <div id="error"></div>
                </form>
            </div>
            ';
        View::end();
    }

    public static function añadir($id){

        View::start('Artencuentro');
        View::topnav();

        echo '
            <div id="form">
                <form name="myForm" method="POST" class="formulario" enctype="multipart/form-data" onsubmit="return validation()">
                    <input name="titulo" type="text" value="" placeholder="Titulo de la obra" required><br>
                    <input name="tipo" type="text" value="" placeholder="Tipo de obra" required><br>
                    <input name="fecha" type="text" value="" placeholder="Fecha de la obra dd/mm/aa" required><br> 
                    <input name="descripcion" type="text" value="" placeholder="Descripción" required><br>
                    <input type="file" name="image"><br>
                    <input type="submit" value="Aceptar" name="Añadir">
                    <div id="error"></div>
                </form>
            </div>
            ';
        View::end();
    }
}