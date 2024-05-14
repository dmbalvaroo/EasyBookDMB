<?php
// reserva_manager.php

class ReservaManager {
    private $conn;

    public function __construct($mysqli) {
        $this->conn = $mysqli;
    }

    // Crear una reserva
    public function crearReserva($fecha_hora, $estado, $id_usuario, $id_servicio) {
        // Asegúrate de que los parámetros sean correctos
        $sql = "INSERT INTO Reserva (fecha_hora, estado, id_usuario, id_servicio) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ssii', $fecha_hora, $estado, $id_usuario, $id_servicio);
        $result = $stmt->execute();
        $stmt->close();

        return $result ? ['success' => true, 'message' => 'Reserva creada exitosamente'] :
                         ['success' => false, 'message' => 'Error al crear la reserva'];
    }

    // Actualizar el estado de una reserva
    public function actualizarEstadoReserva($id_reserva, $estado) {
        $sql = "UPDATE Reserva SET estado = ? WHERE id_reserva = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('si', $estado, $id_reserva);
        $result = $stmt->execute();
        $stmt->close();

        return $result ? ['success' => true, 'message' => 'Reserva actualizada'] :
                         ['success' => false, 'message' => 'Error al actualizar la reserva'];
    }

    // Obtener todas las reservas
    public function obtenerReservas() {
        $sql = "SELECT id_reserva, fecha_hora, estado, id_usuario, id_servicio FROM Reserva";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $reservas = [];
            while ($row = $result->fetch_assoc()) {
                $reservas[] = $row;
            }
            return ['success' => true, 'reservas' => $reservas];
        } else {
            return ['success' => false, 'message' => 'No hay reservas'];
        }
    }
}
?>
