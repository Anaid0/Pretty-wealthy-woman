<?php
session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

require_once("../conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin - Pretty Wealthy Woman</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
</head>
<body>

    <header><h1>Panel Administrativo 💼</h1></header>

    <div class="botones top-actions">
        <button onclick="mostrarFormulario('formProducto')">➕ Agregar Producto</button>
        <button onclick="mostrarFormulario('formVerProveedores')">📋 Ver Proveedores</button>
        <a href="agregar_usuario.php" class="btn-dashboard">👤 Agregar Usuario</a>
        <a href="agregar_proveedor.php" class="btn-dashboard">➕ Agregar Proveedor</a>
        <a href="exportarPDF_ventas.php" class="btn-dashboard">Descargar PDF de ventas</a>
        <a href="../logout.php" class="btn-dashboard">🚪 Cerrar sesión</a>

    </div>

    <!-- ✅ Modal Agregar Producto -->
    <div class="modal" id="formProducto">
        <div class="modal-contenido">
            <span class="cerrar" onclick="ocultarFormulario('formProducto')">&times;</span>
            <?php include('agregar_producto.php'); ?>
        </div>
    </div>

    <!-- ✅ Modal Ver Proveedores -->
    <div class="modal" id="formVerProveedores">
        <div class="modal-contenido">
            <span class="cerrar" onclick="ocultarFormulario('formVerProveedores')">&times;</span>
            <h2>Lista de Proveedores</h2> <a href="exportarPDF_proveedores.php" class="btn-dashboard">Descargar PDF</a>
            <table class="tabla-proveedores">
                <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $resultado = $conexion->query("SELECT * FROM proveedores");
                        if ($resultado->num_rows > 0) {
                        while ($proveedor = $resultado->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$proveedor['nombre_empresa']}</td>";
                        echo "<td>{$proveedor['telefono']}</td>";
                        echo "<td>{$proveedor['email']}</td>";
                        echo "<td>
                        <button onclick='abrirModalEditarProveedor(" . json_encode($proveedor) . ")'>✏️ Editar</button>
                        <form method=\"POST\" action=\"eliminar_proveedor.php\" style=\"display:inline-block\" onsubmit=\"return confirm(\"¿Seguro que deseas eliminar este proveedor?\")\">
                        <input type=\"hidden\" name=\"id\" value=\"{$proveedor['id']}\">
                        <button type=\"submit\">🗑️ Eliminar</button>
                        </form>
                        </td>";
                        echo "</tr>";
                        }   
                    } else {
                    echo "<tr><td colspan='4'>No hay proveedores registrados.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal flotante para editar proveedor -->
<div class="modal" id="modalEditarProveedor">
  <div class="modal-contenido">
    <span class="cerrar" onclick="cerrarModalEditarProveedor()">&times;</span>
    <h2>Editar Proveedor</h2>
    <form id="formEditarProveedor" action="editar_proveedor.php" method="POST">
      <input type="hidden" name="id" id="prov_id">

      <label>Nombre de la Empresa:</label>
      <input type="text" name="nombre_empresa" id="prov_nombre" required><br>

      <label>Teléfono:</label>
      <input type="text" name="telefono" id="prov_telefono" required><br>

      <label>Email:</label>
      <input type="email" name="email" id="prov_email" required><br>

      <button type="submit">Guardar Cambios</button>
    </form>
  </div>
</div>


    <!-- ✅ Tabla de Productos -->
    <h2 style="text-align:center;">Lista de Productos</h2> <a href="exportarPDF_productos.php" class="btn-dashboard">Descargar PDF</a>
    <table class="tabla-productos">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Proveedor</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT p.*, pr.nombre_empresa 
                    FROM productos p
                    JOIN proveedores pr ON p.id_proveedor = pr.id";
            $productos = $conexion->query($sql);
            if ($productos->num_rows > 0) {
                while ($producto = $productos->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><img src='../../{$producto['imagen']}' width='60'></td>";
                    echo "<td>{$producto['nombre']}</td>";
                    echo "<td>{$producto['descripcion']}</td>";
                    echo "<td>$" . number_format($producto['precio'], 2) . "</td>";
                    echo "<td>{$producto['stock']}</td>";
                    echo "<td>{$producto['nombre_empresa']}</td>";
                    echo "<td>{$producto['activo']}</td>";
                    echo "<td>
                        <button onclick='abrirModalEditar(" . htmlspecialchars(json_encode($producto)) . ")'>✏️ Editar</button>
                        <button onclick='eliminarProducto({$producto['id_producto']})'>🗑️ Eliminar</button>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No hay productos registrados.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- ✅ Modal Editar Producto -->
    <div class="modal" id="modalEditar">
        <div class="modal-contenido">
            <span class="cerrar" onclick="cerrarModalEditar()">&times;</span>
            <form id="formEditar" action="./editar_producto.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_producto" id="edit_id">
                <label>Nombre:</label><input type="text" name="nombre" id="edit_nombre" required><br>
                <label>Descripción:</label><textarea name="descripcion" id="edit_descripcion" required></textarea><br>
                <label>Precio:</label><input type="number" name="precio" id="edit_precio" step="0.01" required><br>
                <label>Stock:</label><input type="number" name="stock" id="edit_stock" required><br>
                <label>Proveedor:</label>
                <select name="id_proveedor" id="edit_proveedor">
                    <?php
                    $proveedores = $conexion->query("SELECT id, nombre_empresa FROM proveedores");
                    while ($prov = $proveedores->fetch_assoc()) {
                        echo "<option value='{$prov['id']}'>{$prov['nombre_empresa']}</option>";
                    }
                    ?>
                </select><br>
                <label>Imagen (opcional):</label><input type="file" name="imagen"><br>
                <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </div>

    <!-- ✅ Tabla de Usuarios -->
    <h2 style="text-align:center;">Usuarios Registrados</h2><a href="exportarPDF_usuarios.php" class="btn-dashboard">Descargar PDF</a>
<table class="tabla-productos">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Documento</th>
            <th>Celular</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $usuarios = $conexion->query("SELECT * FROM usuarios");
    if ($usuarios->num_rows > 0) {
        while ($usuario = $usuarios->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$usuario['nombre']}</td>";
            echo "<td>{$usuario['documento']}</td>";
            echo "<td>{$usuario['celular']}</td>";
            echo "<td>{$usuario['correo']}</td>";
            echo "<td>{$usuario['rol']}</td>";
            echo "<td>{$usuario['estado']}</td>";
            echo "<td>
                <button onclick='abrirModalEditarUsuario(" . htmlspecialchars(json_encode($usuario)) . ")'>✏️ Editar</button>
                <form method=\"POST\" action=\"eliminar_usuario.php\" style=\"display:inline-block\" onsubmit=\"return confirm(\"¿Eliminar este usuario?\")\">
                    <input type=\"hidden\" name=\"id_usuario\" value=\"{$usuario['id_usuario']}\">
                    <button type=\"submit\">🗑️ Eliminar</button>
                </form>
            </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No hay usuarios registrados.</td></tr>";
    }
    ?>
    </tbody>
</table>

<!-- ✅ Modal Editar Usuario -->
<div class="modal" id="modalEditarUsuario">
  <div class="modal-contenido">
    <span class="cerrar" onclick="cerrarModalEditarUsuario()">&times;</span>
    <h2>Editar Usuario</h2>
    <form id="formEditarUsuario" action="editar_usuario.php" method="POST">
      <input type="hidden" name="id_usuario" id="user_id">

      <label>Nombre:</label>
      <input type="text" name="nombre" id="user_nombre" required><br>

      <label>Documento:</label>
      <input type="text" name="documento" id="user_documento" required><br>

      <label>Celular:</label>
      <input type="text" name="celular" id="user_celular" required><br>

      <label>Correo:</label>
      <input type="email" name="correo" id="user_correo" required><br>

      <label>Rol:</label>
      <select name="rol" id="user_rol" required>
        <option value="admin">Admin</option>
        <option value="cliente">Cliente</option>
      </select><br>

      <button type="submit">Guardar Cambios</button>
    </form>
  </div>
</div>


    <script src="../../js/dashboard.js"></script>
</body>
</html>
