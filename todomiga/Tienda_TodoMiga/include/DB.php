<?php
require_once('include/Producto.php');
spl_autoload_register(function ($clase) {
    include  $clase . 'php';
});

class DB {  

    public static function insertarUsuario(){
        try {
             
            $opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        $dsn = "mysql:host=localhost;dbname=todomiga";
        $usuario = 'root';
        $contrasena = '';
        
        $todomiga = new PDO($dsn, $usuario, $contrasena, $opc);
            if ($todomiga != false) {
                $todomiga->beginTransaction();
                $ok = true;
    
                $consulta = $todomiga->prepare("INSERT INTO usuarios (usuario, contrasena) "
                    . "VALUES ('usuario2','1234')  ");


            }else{
                echo "Error al conectar a la base de datos";
            }
        } catch (PDOException $error) {
            echo "Error: " . $error->getMessage();
            return false;
        }
    }
    protected static function ejecutaConsulta($sql) {
        $opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        $dsn = "mysql:host=localhost;dbname=todomiga";
        $usuario = 'root';
        $contrasena = '';
        
        $todomiga = new PDO($dsn, $usuario, $contrasena, $opc);
        $resultado = null;
        if (isset($todomiga)) $resultado = $todomiga->query($sql);
        return $resultado;
    }

    public static function obtieneProductos() {
        $sql = "SELECT cod_producto, nombre_prod, cod_categoria, precio, imagen_prod FROM producto;";
        $resultado = self::ejecutaConsulta ($sql);
        $productos = array();
        

	if($resultado) {
            // Añadimos un elemento por cada producto obtenido
            $row = $resultado->fetch();
            while ($row != null) {
                $productos[] = new Producto($row);
                $row = $resultado->fetch();
            }
	}
        
        return $productos;
    }

    
    public static function obtieneProducto($cod_producto) {
        $sql = "SELECT cod_producto, nombre_prod, cod_categoria, precio FROM producto";
        $sql .= " WHERE cod_producto='" . $cod_producto . "'";
        $resultado = self::ejecutaConsulta ($sql);
        $producto = null;
       

	if(isset($resultado)) {
            $row = $resultado->fetch();
            $producto = new Producto($row);
	}
        
        return $producto;    
    }
    
    public static function verificaCliente($nombre, $contrasena) {
        $sql = "SELECT usuario FROM usuarios ";
        $sql .= "WHERE usuario='$nombre' ";
        $sql .= "AND contrasena='" . md5($contrasena) . "';";
        $resultado = self::ejecutaConsulta ($sql);
        $verificado = false;

        if(isset($resultado)) {
            $fila = $resultado->fetch();
            if($fila !== false) $verificado=true;
        }
        return $verificado;
    }
    
}

?>
