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

// Creador Abstracto
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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Agendar Cita para el Taller - LowGarage</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background-color: #fff;
            overflow: hidden;
        }
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(0,0,0,0.05) 1px, transparent 1px);
            background-size: 40px 40px;
            animation: moveBackground 8s linear infinite;
            z-index: -1;
        }
        @keyframes moveBackground {
            from { background-position: 0 0; }
            to { background-position: 40px 40px; }
        }
        nav {
            background-color: rgba(30, 60, 114, 0.9);
            color: white;
            padding: 1rem 2rem;
            font-size: 1.5rem;
            text-align: center;
        }
        .container {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .card {
            background-color: white;
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            text-align: center;
            animation: fadeIn 0.8s ease-in-out;
        }
        h1 {
            color: #1e3c72;
            margin-bottom: 20px;
        }
        label {
            font-weight: 600;
            display: block;
            margin-top: 1rem;
            color: #2a5298;
        }
        input, select {
            width: 100%;
            margin-top: 0.5rem;
            padding: 0.9rem;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
            background-color: #f9f9f9;
        }
        input:focus, select:focus {
            outline: none;
            border-color: #2a5298;
            box-shadow: 0 0 8px rgba(42, 82, 152, 0.3);
        }
        button {
            background-color: #2a5298;
            color: white;
            border: none;
            margin-top: 1.5rem;
            cursor: pointer;
            padding: 1rem;
            font-size: 1rem;
            border-radius: 8px;
            width: 100%;
            transition: all 0.3s ease;
        }
        button:hover {
            background-color: #1e3c72;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(30, 60, 114, 0.3);
        }
        footer {
            background-color: #1e3c72;
            height: 50px;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <nav>LowGarage</nav>
    <div class="container">
        <div class="card">
            <h1>Agendar Cita para el Taller</h1>
            <form method="post">
                <label>Nombre del Cliente:</label>
                <input type="text" name="cliente" placeholder="Ingrese su nombre" required>

                <label>Fecha (dd/mm/aaaa):</label>
                <input type="date" name="fecha" required>

                <label>Tipo de Cita:</label>
                <select name="tipo">
                    <option value="mantenimiento">Mantenimiento</option>
                    <option value="reparacion">Reparación</option>
                </select>

                <button type="submit">Agendar Cita</button>
            </form>
        </div>
    </div>
    <footer></footer>
</body>
</html>
