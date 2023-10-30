<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "gallery";
 
    // Crear conexion
    $conex = new mysqli($servername, $username, $password, $database);

    $id = "";
    $descripcion = "";

    $errorMessage = "";
    $successMessage = "";

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // Método GET: Mostrar los datos del usuario

        if (!isset($_GET["id"])) {
            header("location: /gallery/crudcate/index.php");
            exit;
        }

        $id = $_GET["id"];

        // Leer la fila del cliente seleccionado de la tabla de la base de datos
        $sql = "SELECT * FROM categorias WHERE idCategoria=$id";
        $result = $conex->query($sql);
        $row = $result->fetch_assoc();

        if (!$row) {
            header("location: /gallery/crudkarencategorias/index.php");
            exit;
        }

        $descripcion = $row["descripcion"];
    }
    else {
        // Método POST: Actualizar los datos del usuario

        $id = $_POST["id"];
        $descripcion = $_POST["descripcion"];

        do {
            if (empty($id) || empty($descripcion)) {
                $errorMessage = "Todos los campos son requeridos";
                break;
            }

            $sql = "UPDATE categorias " .
                   "SET descripcion = '$descripcion'" . 
                   "WHERE idCategoria = $id";

            $result = $conex->query($sql);

            if (!$result) {
                $errorMessage = "Consulta inválida: " . $conex->error;
                break;
            }

            $successMessage = "Categoria actualizada correctamente";

            header("location: /gallery/crudcate/index.php");
            exit;

        } while (true);
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My CRUD</title>
    <link rel="stylesheet" href="/gallery/boostrap/bootstrap513/css/bootstrap.min.css">
    <script src=></script>
</head>
<body>
    <div class="container my-5">
        <h2>Nuevo categoría</h2>

        <?php
            if (!empty($errorMessage)) {
                echo "
                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>$errorMessage</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>                ";
            }
        ?>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
  
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Descripción</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="descripcion" value="<?php echo $descripcion; ?>">
                </div>
            </div>

            <?php
                if (!empty($successMessage)) {
                    echo "
                    <div class='row mb-3'>
                        <div class='offset-sm-3 col-sm-6'>
                            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                <strong>$successMessage</strong>
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>
                        </div>
                    </div>
                    ";
                }
            ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/gallery/crudkarencategorias/index.php" role="button">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>