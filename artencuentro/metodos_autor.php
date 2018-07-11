<?php
include_once 'presentation.class.php';

View::start('Artencuentro');
View::topnav();

$id = $_GET['id'];
$met = $_GET['value'];

$id2=User::getLoggedUser()['id'];
$nombre=User::getLoggedUser()['nombre'];
$idautor=User::getLoggedUser()['id'];

if(isset($_POST['Editar'])){
    //Obtenemos los valores
    $val = metodos_autor::conseguirValores();

    //parte de modificación
    if ($val[0] == true){
        db::execute_sql("UPDATE obras SET titulo=?, tipo=?, fecha = ?, descripcion=? WHERE id=?",array($val[1],$val[2],$val[3],$val[4],$id));
        header("Location: autores.php?id=$id2&nombre=$nombre&idautor=$idautor");
    }
}

if(isset($_POST['Añadir'])){
    //Obtenemos los valores
    $val = metodos_autor::conseguirValores();

    $image = file_get_contents($_FILES['image']['tmp_name']);

    if ($val[0] == true){
        db::execute_sql("INSERT INTO obras(idautor, titulo, tipo, fecha, descripcion,imagen) VALUES (?,?,?,?,?,?)",array($id,$val[1],$val[2],$val[3],$val[4],$image));
        header("Location: autores.php?id=$id2&nombre=$nombre&idautor=$idautor");
    }
}

switch($met){
    case 'añadir';
        metodos_autor::añadir($id);
        break;
    case 'eliminar';
        metodos_autor::eliminar($id);
        break;
    case 'editar';
        metodos_autor::editar($id);
        break;
}

class metodos_autor{
    public static function eliminar($id){

        $id2=User::getLoggedUser()['id'];
        $nombre= User::getLoggedUser()['nombre'];
        $idautor=User::getLoggedUser()['id'];

        db::execute_sql("DELETE FROM obras WHERE id=?",array($id));
        //opcional mensaje de me has comido el nabo
        header("Location: autores.php?id=$id2&nombre=$nombre&idautor=$idautor");
    }

    public static function editar($id){
        $obra = db::execute_sql('SELECT * FROM obras WHERE id=?', array($id));
        $obra->setFetchMode(PDO::FETCH_NAMED);
        $obra = $obra->fetchAll();
        $obra = $obra[0];
        echo '
            <div>
                <form method="POST" class="formulario">
                    <a>titulo</a>
                    <a class="blockinput"><input type="text" name="titulo" value="'.$obra['titulo'].'" placeholder="..."></a><br>
                    <a>tipo</a> 
                    <a class="blockinput"><input type="text" name="tipo" value="'.$obra['tipo'].'" placeholder="..."></a><br>
                    <a>fecha</a> 
                    <a class="blockinput"><input type="text" name="fecha" value="'.$obra['fecha'].'" placeholder="..."></a><br>
                    <a>descripcion</a> 
                    <a class="blockinput"><input type="text" name="descripcion" value="'.$obra['descripcion'].'" placeholder="..."></a><br>
                    <input type="submit" value="Aceptar" name="Editar">
                </form>
            </div>
            ';
        View::end();

    }

    public static function añadir($id){
        echo '
                <form method="POST" class="formulario" enctype="multipart/form-data">
                    <input type="text" name="titulo" value="" placeholder="Titulo de la obra"><br>
                    <input type="text" name="tipo" value="" placeholder="Tipo de obra"><br>
                    <input type="text" name="fecha" value="" placeholder="Fecha de la obra dd/mm/aa"><br> 
                    <input type="text" name="descripcion" value="" placeholder="Descripción"><br>
                    <input type="file" name="image"><br>
                    <input type="submit" value="Aceptar" name="Añadir">
                </form>
            </div>
            ';
        View::end();
    }


    //Funciones auxiliares para las funciones añadir/editar
    static function conseguirValores(){
        //Comprobación de seguridad
        $titulo=metodos_autor::test_input($_POST['titulo']);
        $tipo=metodos_autor::test_input($_POST['tipo']);
        $fecha=metodos_autor::test_input($_POST['fecha']);
        $descripcion=metodos_autor::test_input($_POST['descripcion']);

        //Comprobación de formato
        /*
    titulo: mínimo 2 caracteres y máximo 32 caracteres
    tipo: mínimo 5 caracteres y máximo 16 caracteres, solo minúsculas y espacios
    fecha: formato correcto [d]d/[m]m/aaaa y fecha posible
    descripción: mínimo 12 y máximo 1024 caracteres
         */
        $resultado=true;
        //titulo
        if(!preg_match('/^.{2,32}$/',$titulo)){
            echo '<p>Titulo mal introducido: mínimo 2 caracteres y máximo 32 caracteres</p>';
            $resultado=false;
        }

        //tipo
        if(!preg_match('/^[a-z ]{5,16}$/',$tipo)){
            echo '<p>Tipo mal introducido: mínimo 5 caracteres y máximo 16 caracteres, solo minúsculas y espacios</p>';
            $resultado=false;
        }

        //fecha
        if(isset($fecha)){
            list($dd,$mm,$yyyy) = explode('/',$fecha);
            if(($dd != ' ')&&($mm != ' ')&&($yyyy != ' ')){
                if(!checkdate($mm,$dd,$yyyy)){
                    $resultado=false;
                    echo '<p>Fecha mal introducida: formato [d]d/[m]m/aaaa</p>';
                }
            }else{
                $resultado=false;
                echo '<p>Fecha mal introducida: formato [d]d/[m]m/aaaa</p>';
            }
        }else{
            $resultado=false;
            echo '<p>Fecha mal introducida: formato [d]d/[m]m/aaaa</p>';
        }

        //descripcion
        if(!preg_match("/^.{12,1024}$/",$descripcion)){
            $resultado=false;
            echo '<p>Descripción mal introducida: mínimo 12 caracteres y máximo 1024 caracteres</p>';
        }else {$campos[3] = false;}

        return array($resultado,$titulo,$tipo,$fecha,$descripcion);
    }

    static function test_input($campo) {
        $campo = trim($campo);
        $campo = stripslashes($campo);
        $campo = htmlspecialchars($campo);
        return $campo;
    }
}