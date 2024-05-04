<?php
class Servicio {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getServicesByType($tipo_servicio) {
        $stmt = $this->db->prepare("SELECT id_servicio, nombre_servicio, descripcion, precio, duracion FROM Servicio WHERE tipo_servicio = ?");
        $stmt->bind_param("s", $tipo_servicio);
        $stmt->execute();
        $result = $stmt->get_result();

        $services = [];
        while ($row = $result->fetch_assoc()) {
            $services[] = $row;
        }
        $stmt->close();

        return $services;
    }
}

?>