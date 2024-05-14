<?php
// operations.php

include('conexionbd.php');

// Crear Establecimiento
function crearEstablecimiento($nombre, $direccion, $id_empresa) {
    global $conn;
    $sql = "INSERT INTO Establecimiento (nombre, direccion, id_empresa) VALUES ('$nombre', '$direccion', $id_empresa)";
    return $conn->query($sql);
}

// Eliminar Establecimiento
function eliminarEstablecimiento($id_establecimiento) {
    global $conn;
    $sql = "DELETE FROM Establecimiento WHERE id_establecimiento = $id_establecimiento";
    return $conn->query($sql);
}

// Crear Usuario
function crearUsuario($nombre, $apellido, $correo, $contrasena, $telefono, $nivel, $tipo) {
    global $conn;
    $sql = "INSERT INTO Usuario (nombre, apellido, correo_electronico, contrasena, telefono, nivel_acceso, tipo_usuario)
            VALUES ('$nombre', '$apellido', '$correo', '$contrasena', '$telefono', '$nivel', '$tipo')";
    return $conn->query($sql);
}

// Eliminar Usuario
function eliminarUsuario($id_usuario) {
    global $conn;
    $sql = "DELETE FROM Usuario WHERE id_usuario = $id_usuario";
    return $conn->query($sql);
}

// Crear Empresa
function crearEmpresa($nombre, $descripcion, $telefono, $id_usuario_admin) {
    global $conn;
    $sql = "INSERT INTO Empresa (nombre, descripcion, telefono, id_usuario_admin)
            VALUES ('$nombre', '$descripcion', '$telefono', $id_usuario_admin)";
    return $conn->query($sql);
}

// Eliminar Empresa
function eliminarEmpresa($id_empresa) {
    global $conn;
    $sql = "DELETE FROM Empresa WHERE id_empresa = $id_empresa";
    return $conn->query($sql);
}

// Crear Servicio
function crearServicio($nombre_servicio, $descripcion, $precio, $duracion, $tipo_servicio) {
    global $conn;
    $sql = "INSERT INTO Servicio (nombre_servicio, descripcion, precio, duracion, tipo_servicio)
            VALUES ('$nombre_servicio', '$descripcion', $precio, $duracion, '$tipo_servicio')";
    return $conn->query($sql);
}

// Eliminar Servicio
function eliminarServicio($id_servicio) {
    global $conn;
    $sql = "DELETE FROM Servicio WHERE id_servicio = $id_servicio";
    return $conn->query($sql);
}

// Crear Reserva
function crearReserva($fecha_hora, $estado, $id_usuario, $id_servicio) {
    global $conn;
    $sql = "INSERT INTO Reserva (fecha_hora, estado, id_usuario, id_servicio)
            VALUES ('$fecha_hora', '$estado', $id_usuario, $id_servicio)";
    return $conn->query($sql);
}

// Eliminar Reserva
function eliminarReserva($id_reserva) {
    global $conn;
    $sql = "DELETE FROM Reserva WHERE id_reserva = $id_reserva";
    return $conn->query($sql);
}
?>
