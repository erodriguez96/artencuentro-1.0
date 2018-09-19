<?php
include_once 'business.class.php';

class View
{
    public static function start($title)
    {
        $html = "<!DOCTYPE html>
        <html>
        <head>
        <meta charset=\"utf-8\">
        <link rel=\"stylesheet\" type=\"text/css\" href=\"estilos/estilos.css\">
        <script src=\"scripts.js\"></script>
        <script src=\"jquery-3.3.1.min.js\"></script>
        <title>$title</title>
        </head>
        <body>";
        User::session_start();
        echo $html;
    }

    public static function topnav(){
        $log = "";
        $user = "";
        $func = "";
        $aux1="";
        $aux2="";
        if (!User::getLoggedUser()) {
            $log = '<a href="login.php?value=1">Login</a>';
        } else {
            $user = User::getLoggedUser()['nombre'];
            $log = '<a href="login.php?value=0">Logout</a>';

            $id = User::getLoggedUser()['id'];
            $nombre = User::getLoggedUser()['nombre'];
            $idautor = User::getLoggedUser()['id'];

            $array = $_SESSION['user'];
            $tipo = $array['tipo'];

            switch ($array['tipo']) {
                case 1: //admin
                    $func = '<a href="admin.php">' . $user . '</a>';
                    break;
                case 2: //autor
                    $func = '<a>' . $user . '</a>';
                    $aux1 = "<a href='autores.php?id=$id&nombre=$nombre&idautor=$idautor'>Mis Obras</a>";
                    $aux2 = "<a href='propuestas.php?id=$id&tipo=$tipo'> Mis Propuestas </a>";
                    break;
                case 3: //empresa
                    $func = '<a>' . $user . '</a>';
                    $aux1 = "<a href='propuestas.php?id=$id&tipo=$tipo'>Ver mis propuestas</a>";
                    break;
            }
        }

        echo '

        <div class="header">
            <h1><b><a href="index.php">Artencuentro</a></b></h1>
        </div>

        <div class="topnav">
            <a href="visitante.php"><b>Ver nuestros trabajos</b></a>
            <div id="padre">
                <form method="post" action="visitante.php">
                    <div id="barra"> 
                        <input type="text" id="myFilterList" name="buscar" placeholder="Search.." onkeyup="myFilterList()">
                            '.$aux1.'
                            '.$aux2.'
                            '.$func.'
                            '.$log.'
                    </div>
                </form>
            </div>
        </div>
        ';
    }

    public static function navigation()
    {
        echo '<nav>';
        echo '</nav>';
    }

    public static function end()
    {
        echo '</body></html>';
    }
}
