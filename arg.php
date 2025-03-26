<?php
interface CitaInterface {
    public function mostrarDetalles();
}

// Clases de Cita
class CitaMantenimiento implements CitaInterface {
    private $cliente;
    private $fecha;

    public function __construct($cliente, $fecha) {
        $this->cliente = $cliente;
        $this->fecha = $fecha;
    }

    public function mostrarDetalles() {
        return "Cita de Mantenimiento para $this->cliente el $this->fecha";
    }
}

class CitaReparacion implements CitaInterface {
    private $cliente;
    private $fecha;

    public function __construct($cliente, $fecha) {
        $this->cliente = $cliente;
        $this->fecha = $fecha;
    }

    public function mostrarDetalles() {
        return "Cita de Reparación para $this->cliente el $this->fecha";
    }
}

// Aqui usamos el Factory Method 
//Este método actúa como Factory Method y obliga a las clases hijas a implementar su propia lógica para crear los objetos.
abstract class CreadorCita {
    abstract public function crearCita($cliente, $fecha): CitaInterface;
}

// Creadores Concretos
class CreadorCitaMantenimiento extends CreadorCita {
    public function crearCita($cliente, $fecha): CitaInterface {
        return new CitaMantenimiento($cliente, $fecha);
    }
}

class CreadorCitaReparacion extends CreadorCita {
    public function crearCita($cliente, $fecha): CitaInterface {
        return new CitaReparacion($cliente, $fecha);
    }
}

// Controlador
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente = $_POST['cliente'];
    $fecha = $_POST['fecha'];
    $tipo = $_POST['tipo'];

    $creador = ($tipo === 'mantenimiento') ? new CreadorCitaMantenimiento() : new CreadorCitaReparacion();
    $cita = $creador->crearCita($cliente, $fecha);

    echo $cita->mostrarDetalles();
}
?>