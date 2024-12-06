<?php
class Perfiles {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerPerfiles() {
        $query = "SELECT * FROM perfiles ORDER BY id_perfil ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearPerfil($nombre_perfil) {
        if (empty($nombre_perfil)) {
            return false;
        }
        $query = "INSERT INTO perfiles (nombre_perfil) VALUES (:nombre_perfil)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nombre_perfil", $nombre_perfil);
        return $stmt->execute();
    }

    public function eliminarPerfil($id_perfil) {
        $query = "DELETE FROM perfiles WHERE id_perfil = :id_perfil";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_perfil", $id_perfil);
        return $stmt->execute();
    }

    public function obtenerPerfilPorId($id_perfil) {
        $query = "SELECT * FROM perfiles WHERE id_perfil = :id_perfil";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_perfil", $id_perfil);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarPerfil($id_perfil, $nombre_perfil) {
        $query = "UPDATE perfiles SET nombre_perfil = :nombre_perfil WHERE id_perfil = :id_perfil";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nombre_perfil", $nombre_perfil);
        $stmt->bindParam(":id_perfil", $id_perfil);
        return $stmt->execute();
    }
}
?>
