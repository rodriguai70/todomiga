<?php
require_once('include/DB.php');
require_once('include/CestaCompra.php');

// Recuperamos la información de la sesión
session_start();

// Y comprobamos que el usuario se haya autentificado
if (!isset($_SESSION['usuario']))
  die("Error - debe <a href='login.php'>identificarse</a>.<br />");

// Recuperamos la cesta de la compra

$cesta = CestaCompra::carga_cesta();



// Comprobamos si se ha enviado el formulario de vaciar la cesta
if (isset($_POST['vaciar'])) {
  unset($_SESSION['cesta']);
  $cesta = new CestaCompra();
}

// Comprobamos si se quiere añadir un producto a la cesta
if (isset($_POST['enviar']) && isset($_POST['cod_producto'])) {
  $cesta->nuevo_articulo($_POST['cod_producto']);
  $cesta->guarda_cesta();
}

// Comprobamos si se quiere eliminar un producto
if (isset($_POST['quitar'])) {
  $cesta->eliminaProducto($_POST['cod_producto']);
  header("Location: productos.php");
  exit();
}

// Obtener lista de productos
$productos = DB::obtieneProductos();

/*function creaFormularioProductos()
{
  $productos = DB::obtieneProductos();
  foreach ($productos as $p) {
    echo "<p><form id='" . $p->getcodproducto() . "' action='productos.php' method='post'>";

    echo "<input type='hidden' name='cod_producto' value='" . $p->getcodproducto() . "'/>";
    echo "<input type='submit' name='enviar' value='Añadir'/>";
    echo $p->getnombreprod() . ": ";
    echo $p->getprecio() . " euros.";
    echo "</form>";
    echo "</p>";
  }
}
function creaFormularioProductos()
{
  $productos = DB::obtieneProductos();

  echo "<h2>Productos disponibles</h2>";
  echo "<table class='tablaProductos'>";
  echo "<thead>
            <tr>
                <th>IMAGEN</th>    
                <th>CÓDIGO</th>
                <th>NOMBRE</th>
                <th>PRECIO</th>
                <th>AÑADIR A CESTA</th>
            </tr>
          </thead>";
  echo "<tbody>";

  foreach ($productos as $p) {
    $cod_producto = htmlspecialchars($p->getcodproducto());
    $nombre_prod = htmlspecialchars($p->getnombreprod());
    $precio = htmlspecialchars($p->getprecio());

    // Imagen con fallback si no existe
    $rutaImagen = htmlspecialchars($p->getImagen());

    echo "<tr>";
    echo "<td><img src='$rutaImagen' alt='$nombre_prod' width='80' onerror=\"this.src='imagenes/default.png'\"/></td>";
    echo "<td>$cod_producto</td>";
    echo "<td>$nombre_prod</td>";
    echo "<td>$precio €</td>";

    echo "<td>
        <form action='productos.php' method='post' style='display:inline; margin:0;'>
            <input type='hidden' name='cod_producto' value='" . htmlspecialchars($p->getcodproducto()) . "'/>
            <input type='submit' name='enviar' value='Añadir'/>
        </form>
      </td>";
    echo "</tr>";
  }

  echo "</tbody>";
  echo "</table>";
}
*/
function creaFormularioProductos()
{
  $productos = DB::obtieneProductos();

  echo "<div class='contenedor-tabla'>";
  echo "<h2>Productos disponibles</h2>";
  echo "<table class='tablaProductos'>";
  echo "<thead>
            <tr>
                <th>IMAGEN</th>    
                <th>CÓDIGO</th>
                <th>NOMBRE</th>
                <th>PRECIO</th>
                <th>AÑADIR A CESTA</th>
            </tr>
          </thead>";
  echo "<tbody>";

  foreach ($productos as $p) {
    $cod_producto = htmlspecialchars($p->getcodproducto());
    $nombre_prod = htmlspecialchars($p->getnombreprod());
    $precio = htmlspecialchars($p->getprecio());
    $rutaImagen = htmlspecialchars($p->getImagen());

    echo "<tr>";
    echo "<td><img src='$rutaImagen' alt='$nombre_prod' width='80' onerror=\"this.src='imagenes/default.png'\"/></td>";
    echo "<td>$cod_producto</td>";
    echo "<td>$nombre_prod</td>";
    echo "<td>$precio €</td>";
    echo "<td>
            <form action='productos.php' method='post'>
              <input type='hidden' name='cod_producto' value='$cod_producto'/>
              <input type='submit' name='enviar' value='Añadir'/>
            </form>
          </td>";
    echo "</tr>";
  }

  echo "</tbody>";
  echo "</table>";
  echo "</div>";
}
function muestraCestaCompra($cesta)
{

  echo "<h3><img src='cesta.png' alt='Cesta' width='24' height='21'> Cesta</h3>";
  echo "<hr />";
  $cesta->muestra();
  echo "<form id='vaciar' action='productos.php' method='post'>";
  echo "<input type='submit' name='vaciar' value='Vaciar Cesta' ";
  if ($cesta->vacia()) echo "disabled='true'";
  echo "/></form>";
  echo "<form id='comprar' action='cesta.php' method='post'>";
  echo "<input type='submit' name='comprar' value='Comprar' ";
  if ($cesta->vacia()) echo "disabled='true'";
  echo "/></form>";
}
if (isset($_POST['quitar'])) {
  $cesta->eliminaProducto($_POST['cod_producto']);
  // Redirigir para evitar reenvío del formulario
  header("Location: productos.php");
  exit();
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Listado de Productos</title>
  <link href="tienda.css" rel="stylesheet" type="text/css">
</head>

<body class="pagproductos">

  <div id="contenedor">
    <div id="encabezado">
      <h1>Listado de productos</h1>


    </div>
    <div id="cesta">
      <?php muestraCestaCompra($cesta); ?>
    </div>
    <div id="productos">
      <?php creaFormularioProductos(); ?>
    </div>
    <br class="divisor" />
    <div id="pie">
      <form action='logoff.php' method='post'>
        <input type='submit' name='desconectar' value='Desconectar usuario <?php echo $_SESSION['usuario']; ?>' />
      </form>
    </div>
  </div>
</body>

</html>