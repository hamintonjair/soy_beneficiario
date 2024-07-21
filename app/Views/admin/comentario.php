<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Jojama" />
        <meta name="author" content="Jojama" />
        <link href="<?php echo base_url(); ?>favicon.ico" rel="icon">

    <title>Administrar Beneficiarios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css" crossorigin="anonymous" />

    <link href="<?php echo base_url(); ?>assets/admin/css/dataTables.dataTables.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/admin/css/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Estilo para el cuerpo y el footer */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            /* Mínimo 100% del viewport height */
        }

        .content {
            flex: 1;
            /* Ocupa todo el espacio disponible */
            padding-bottom: 60px;
            /* Altura del footer */
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #007bff;
            /* Color de fondo del footer */
            color: #fff;
            /* Color del texto del footer */
            text-align: center;
            padding: 10px 0;
            /* Espaciado interno del footer */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">

            <a class="navbar-brand">Administrar Beneficiarios</a>
            <a class="navbar-brand" href="<?php echo base_url(); ?>logout">Cerrar sesion</a>
        </div>
    </nav>

    <div class="content">

        <div class="container mt-5">
            <a href="<?php echo base_url(); ?>admin " type="button" class="btn btn-primary mb-3">
                lista de beneficiarios
            </a>
            <a href="<?php echo base_url(); ?> " type="button" class="btn btn-warning mb-3" target="_blank">
                Ir a sitio beneficiario
            </a>

            <div class="container-fluid px-4 dataTable-container">
                <div class="card-body">
                    <form id="frmConfiguracion">
                        <input type="hidden" id="idempresa" name="idempresa" value="<?= esc($comentarios['id']) ?>">

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="titulo">Titulo</label>
                                <input type="text" id="titulo" name="titulo" class="form-control" value="<?= esc($comentarios['titulo']) ?>" readonly>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="comentario">Comentario</label>
                                <textarea id="comentario" name="comentario" class="form-control" rows="10" readonly><?= esc($comentarios['mensaje']) ?></textarea>
                            </div>
                        </div>
                </div>
                <button type="button" id="btnHabilitar" class="btn btn-secondary">Habilitar Edición</button>
                <button type="submit" class="btn btn-success" id="btnGuardar" disabled>Actualizar</button>
                </form>
            </div>
        </div>

    </div>

    <script>
        document.getElementById('btnHabilitar').addEventListener('click', function() {
            document.getElementById('titulo').removeAttribute('readonly');
            document.getElementById('comentario').removeAttribute('readonly');
            document.getElementById('btnGuardar').removeAttribute('disabled');
        });

        document.getElementById('frmConfiguracion').addEventListener('submit', function(event) {
            event.preventDefault();

            const idempresa = document.getElementById('idempresa').value;
            const titulo = document.getElementById('titulo').value;
            const comentario = document.getElementById('comentario').value;

            $.ajax({
                url: '<?= base_url('comentarios/actualizar') ?>',
                method: 'POST',
                data: {
                    idempresa: idempresa,
                    titulo: titulo,
                    comentario: comentario
                },
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        // Deshabilitar campos de entrada y botones
                        document.getElementById('titulo').setAttribute('readonly', true);
                        document.getElementById('comentario').setAttribute('readonly', true);
                        document.getElementById('btnGuardar').setAttribute('disabled', true);
                    } else {
                        alert(response.message);
                        console.log(response.errors);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    </script>

    </main>
    <br><br><br><br>
    <!-- Pie de página -->
    <footer class="footer bg-primary text-white text-center py-3">
        <div class="container">
            <p>Copyright © Dominio.Todos los derechos reservados por - <a href="https://hammenamena.mercadoshops.com.co/" target="_blank" class="text-white">Jojama</a></p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/sweetalert.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>