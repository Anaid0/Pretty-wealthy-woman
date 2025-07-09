function mostrarFormularioAgregar() {
  document.getElementById('formAgregar').style.display = 'block';
  fetch("../../php/admin/cargar_proveedores.php")
    .then(res => res.text())
    .then(html => {
      document.getElementById("selectProveedores").innerHTML = html;
    });
}

function ocultarFormularioAgregar() {
  document.getElementById('formAgregarProducto').reset();
  document.getElementById('formAgregar').style.display = 'none';
}

function mostrarFormularioProveedor() {
  document.getElementById('formProveedor').style.display = 'block';
}

function ocultarFormularioProveedor() {
  document.getElementById('formAgregarProveedor').reset();
  document.getElementById('formProveedor').style.display = 'none';
}

function cargarProductos() {
  fetch("../../php/admin/listar_productos.php")
    .then(res => res.text())
    .then(html => {
      document.getElementById("contenedor-productos").innerHTML = html;
    });
}

function eliminarProducto(id) {
  if (confirm("¿Estás seguro de eliminar este producto?")) {
    fetch("../../php/admin/eliminar_producto.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `id=${id}`
    })
    .then(res => res.text())
    .then(msg => {
      alert(msg);
      cargarProductos();
    });
  }
}

window.onload = cargarProductos;
