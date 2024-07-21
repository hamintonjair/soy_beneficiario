<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Jojama" />
        <meta name="author" content="Jojama" />
        <link href="<?php echo base_url(); ?>favicon.ico" rel="icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('img/logo.jpg');
            /* Ruta a tu imagen de fondo */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            height: 100vh;
            /* Ajusta el tamaño del cuerpo al 100% del viewport height */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            /* Color de fondo con transparencia para mejorar la legibilidad */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .container h1 {
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .estado-cell {
            background-color: green;
            color: white;
            /* Asegúrate de que el texto sea legible */
            border-radius: 5px;
            padding: 5px;
            margin-right: 15px;
            display: inline-block;
        }

        .estados-cell {
            background-color: red;
            color: white;
            /* Asegúrate de que el texto sea legible */
            border-radius: 5px;
            padding: 5px;
            margin-right: 15px;
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 style="text-align: center;"><?php echo $comentarios['titulo']; ?></h2>
        <br>
        <p style="text-align: justify;"><?php echo nl2br(esc($comentarios['mensaje'])); ?></p>
        <br><br>
        <form action="<?php echo base_url(); ?>search" method="post">
            <div class="form-group row align-items-center">
                <div class="col-md-9">
                    <label for="cedula" class="sr-only">Cédula</label>
                    <input type="number" class="form-control" id="cedula" name="cedula" placeholder="Ingresa tu cédula" required>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary btn-block">Buscar</button>
                </div>
            </div>
        </form>

        <?php if (isset($message)) : ?>
            <div class="mt-4">
                <?php if (isset($beneficiary)) : ?>
                    <?php if ($beneficiary['estado'] == 'Beneficiario') { ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <?= $message ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } else { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $message ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } ?>

                    <table class="table mt-3">
                        <tr>
                            <th>Nombre</th>
                            <td><?= $beneficiary['nombre'] ?></td>
                        </tr>
                        <tr>
                            <th>Apellidos</th>
                            <td><?= $beneficiary['apellidos'] ?></td>
                        </tr>

                        <tr>
                            <th>Ciudad</th>
                            <td><?= $beneficiary['ciudad'] ?></td>
                        </tr>

                        <tr>
                            <th>Estado</th>
                            <?php if ($beneficiary['estado'] == 'Beneficiario') { ?>
                                <td class="estado-cell"><?= esc($beneficiary['estado']) ?></td>
                            <?php } else { ?>
                                <td class="estados-cell"><?= esc($beneficiary['estado']) ?></td>
                            <?php } ?>
                        </tr>
                    </table>
                <?php else : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $message ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
