function mostrarFormulario(id) {
    document.getElementById(id).style.display = "block";
}

function ocultarFormulario(id) {
    document.getElementById(id).style.display = "none";
}

function eliminarProducto(id) {
    if (confirm("¿Estás seguro de eliminar este producto?")) {
        fetch("eliminar_producto.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "id_producto=" + id
        })
        .then(res => res.text())
        .then(respuesta => {
            alert(respuesta);
            location.reload();
        });
    }
}

function abrirModalEditar(producto) {
    document.getElementById("edit_id").value = producto.id_producto;
    document.getElementById("edit_nombre").value = producto.nombre;
    document.getElementById("edit_descripcion").value = producto.descripcion;
    document.getElementById("edit_precio").value = producto.precio;
    document.getElementById("edit_stock").value = producto.stock;
    document.getElementById("edit_proveedor").value = producto.id_proveedor;
    document.getElementById("modalEditar").style.display = "block";
}

function cerrarModalEditar() {
    document.getElementById("modalEditar").style.display = "none";
}

// Función para abrir el modal de editar proveedor
function abrirModalEditarProveedor(proveedor) {
    document.getElementById("prov_id").value = proveedor.id;
    document.getElementById("prov_nombre").value = proveedor.nombre_empresa;
    document.getElementById("prov_telefono").value = proveedor.telefono;
    document.getElementById("prov_email").value = proveedor.email;
    document.getElementById("modalEditarProveedor").style.display = "block";
}

function cerrarModalEditarProveedor() {
    document.getElementById("modalEditarProveedor").style.display = "none";
}

function abrirModalEditarUsuario(usuario) {
  document.getElementById('user_id').value = usuario.id;
  document.getElementById('user_nombre').value = usuario.nombre;
  document.getElementById('user_correo').value = usuario.correo;
  document.getElementById('user_rol').value = usuario.rol;

  document.getElementById('modalEditarUsuario').style.display = 'block';
}

function cerrarModalEditarUsuario() {
  document.getElementById('modalEditarUsuario').style.display = 'none';
}
