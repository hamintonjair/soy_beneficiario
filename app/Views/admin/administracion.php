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
    <!-- Mensajes de éxito y error -->
    <?php if (session()->has('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php elseif (session()->has('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session('error') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <div class="content">

        <div class="container mt-5">
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addBeneficiaryModal">
                Agregar Beneficiario
            </button>
            <a href="<?php echo base_url(); ?>admin/comentario " type="button" class="btn btn-info mb-3">
                Comentario
            </a>
            <a href="<?php echo base_url(); ?> " type="button" class="btn btn-warning mb-3" target="_blank">
                Ir a sitio beneficiario
            </a>

            <!-- Buscador -->
            <form id="searchForm" method="get" action="<?= base_url('admin') ?>" class="form-inline my-3">
                <input type="text" id="searchInput" name="search" value="<?= esc($search) ?>"
                 class="form-control mr-2" placeholder="Buscar..." autocomplete="off">Preciona enter luego
            </form>

            <div class="container-fluid px-4 dataTable-container">
                <!-- Tabla -->
                <table class="table table-bordered" class="table table-striped table-bordered" style="width:100%">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Cédula</th>
                            <th>Ciudad</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($beneficiaries) && is_array($beneficiaries)) : ?>
                            <?php foreach ($beneficiaries as $beneficiary) : ?>
                                <tr>
                                    <td><?= esc($beneficiary['id']) ?></td>
                                    <td><?= esc($beneficiary['nombre']) ?></td>
                                    <td><?= esc($beneficiary['apellidos']) ?></td>
                                    <td><?= esc($beneficiary['cedula']) ?></td>
                                    <td><?= esc($beneficiary['ciudad']) ?></td>
                                    <td><?= esc($beneficiary['estado']) ?></td>

                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning edit-btn" data-id="<?= $beneficiary['id'] ?>" data-toggle="modal" data-target="#editBeneficiaryModal<?= $beneficiary['id'] ?>">
                                            <i class="fas fa-edit"></i> <!-- Icono de lápiz para editar -->
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="<?= $beneficiary['id'] ?>">
                                            <i class="fas fa-trash-alt"></i> <!-- Icono de basura para eliminar -->
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5">No se encontraron beneficiarios</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Enlaces de paginación -->
                <div class="mt-3">
                    <nav aria-label="Page navigation">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <?php
                                $currentPage = $pager->getCurrentPage(); // Página actual
                                $totalPages = $totalPages; // Total de páginas
                                ?>

                                <!-- Botón "Anterior" -->
                                <?php if ($currentPage > 1) : ?>
                                    <li class="page-item">
                                        <button class="page-link" onclick="goToPage(<?= $currentPage - 1 ?>)">Previous</button>
                                    </li>
                                <?php else : ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                <?php endif; ?>

                                <!-- Mostrar primera página -->
                                <?php if ($currentPage > 3) : ?>
                                    <li class="page-item">
                                        <button class="page-link" onclick="goToPage(1)">1</button>
                                    </li>
                                    <?php if ($currentPage > 4) : ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <!-- Botones de páginas alrededor de la página actual -->
                                <?php
                                $startPage = max(1, $currentPage - 2);
                                $endPage = min($totalPages, $currentPage + 2);
                                for ($i = $startPage; $i <= $endPage; $i++) : ?>
                                    <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                        <button class="page-link" onclick="goToPage(<?= $i ?>)"><?= $i ?></button>
                                    </li>
                                <?php endfor; ?>

                                <!-- Mostrar última página -->
                                <?php if ($currentPage < $totalPages - 2) : ?>
                                    <?php if ($currentPage < $totalPages - 3) : ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    <?php endif; ?>
                                    <li class="page-item">
                                        <button class="page-link" onclick="goToPage(<?= $totalPages ?>)"><?= $totalPages ?></button>
                                    </li>
                                <?php endif; ?>

                                <!-- Botón "Siguiente" -->
                                <?php if ($currentPage < $totalPages) : ?>
                                    <li class="page-item">
                                        <button class="page-link" onclick="goToPage(<?= $currentPage + 1 ?>)">Next</button>
                                    </li>
                                <?php else : ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">Next</span>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addBeneficiaryModal" tabindex="-1" aria-labelledby="addBeneficiaryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="addBeneficiaryModalLabel">Agregar Beneficiario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?php echo base_url(); ?>admin/store" method="post">
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nombre">Nombres</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="apellidos">Apellidos</label>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="cedula">Cédula</label>
                                    <input type="number" class="form-control" id="cedula" name="cedula" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="ciudad">Ciudad</label>
                                    <input type="text" class="form-control" id="ciudad" name="ciudad" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <select class="form-control" id="estado" name="estado" required>
                                    <option value="">Seleccione</option>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Beneficiario">Beneficiario</option>
                                    <option value="No beneficiario">No Beneficiario</option>

                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php foreach ($beneficiaries as $beneficiary) : ?>
            <!-- Modal para editar (dentro del bucle) -->
            <div class="modal fade" id="editBeneficiaryModal<?= $beneficiary['id'] ?>" tabindex="-1" aria-labelledby="editBeneficiaryModalLabel<?= $beneficiary['id'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title" id="editBeneficiaryModalLabel<?= $beneficiary['id'] ?>">Editar Beneficiario</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="beneficiaryUpdateForm<?= $beneficiary['id'] ?>" action="<?= base_url('admin/update') ?>" method="post">
                            <div class="modal-body">
                                <input type="hidden" name="id" value="<?= $beneficiary['id'] ?>">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="nombre<?= $beneficiary['id'] ?>">Nombre</label>
                                        <input type="text" class="form-control" id="nombre<?= $beneficiary['id'] ?>" name="nombre" value="<?= $beneficiary['nombre'] ?>" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="apellidos<?= $beneficiary['id'] ?>">Apellidos</label>
                                        <input type="text" class="form-control" id="apellidos<?= $beneficiary['id'] ?>" name="apellidos" value="<?= $beneficiary['apellidos'] ?>" required>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="cedula<?= $beneficiary['id'] ?>">Cédula</label>
                                        <input type="number" class="form-control" id="cedula<?= $beneficiary['id'] ?>" name="cedula" value="<?= $beneficiary['cedula'] ?>" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="ciudad<?= $beneficiary['id'] ?>">Ciudad</label>
                                        <input type="text" class="form-control" id="ciudad<?= $beneficiary['id'] ?>" name="ciudad" value="<?= $beneficiary['ciudad'] ?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="estado<?= $beneficiary['id'] ?>">Estado</label>
                                    <select class="form-control" id="estado<?= $beneficiary['id'] ?>" name="estado" required>
                                        <option value="Pendiente" <?= ($beneficiary['estado'] == 'Pendiente') ? 'selected' : '' ?>>Pendiente</option>
                                        <option value="Beneficiario" <?= ($beneficiary['estado'] == 'Beneficiario') ? 'selected' : '' ?>>Beneficiario</option>
                                        <option value="No beneficiario" <?= ($beneficiary['estado'] == 'No beneficiario') ? 'selected' : '' ?>>No Beneficiario</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>



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
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                if ($.fn.DataTable.isDataTable('#beneficiariesTable')) {
                    $('#beneficiariesTable').DataTable().destroy();
                }

                let table = $('#beneficiariesTable').DataTable({
                    dom: 'lBfrtip', // Definir elementos a mostrar en el DOM
                    buttons: ['copy', 'excel', 'pdf'], // Agregar botones de exportación si lo deseas
                    columnDefs: [{
                            className: "text-center",
                            targets: [6]
                        }, // Alinear texto al centro en columnas Acciones y Estado
                        {
                            className: "text-left",
                            targets: [0, 1, 2, 3, 4, 5]
                        } // Alinear texto a la izquierda en las demás columnas
                    ],
                    responsive: true, // Hacer la tabla responsive
                    iDisplayLength: 10, // Número de registros por página
                    order: [
                        [0, "desc"]
                    ] // Ordenar por la primera columna (ID) de forma descendente
                });

                // Manejar clic en botón de editar
                $('#beneficiariesTable').on('click', '.edit-btn', function() {
                    let id = $(this).data('id');
                    // Obtener los datos del beneficiario por ID
                    $.ajax({
                        url: '<?= base_url('admin/edit/') ?>' + id,
                        method: 'get',
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            // Llenar los campos del formulario modal con los datos del beneficiario
                            $('#nombre' + id).val(response.nombre);
                            $('#apellidos' + id).val(response.apellidos);
                            $('#cedula' + id).val(response.cedula);
                            $('#ciudad' + id).val(response.ciudad);
                            $('#estado' + id).val(response.estado);
                            // Abrir el modal de edición
                            $('#editBeneficiaryModal' + id).modal('show');
                        }
                    });
                });

                // Manejar clic en botón de eliminar
                // Manejar clic en botón de eliminar
                $('#beneficiariesTable').on('click', '.delete-btn', function() {
                    let id = $(this).data('id');
                    swal({
                        title: "¿Estás seguro?",
                        text: "El Beneficiario será eliminado.",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            let base_url = "http://localhost/soy_beneficiario/";
                            $.ajax({
                                url: base_url + 'admin/delete/' + id,
                                type: 'POST',
                                dataType: 'json',
                                success: function(response) {
                                    if (response.ok == true) {
                                        swal({
                                            title: 'Eliminar el beneficiario',
                                            text: response.post,
                                            icon: "success",
                                            button: "OK",
                                        }).then(() => {
                                            window.location.reload();
                                        });
                                    } else {
                                        swal({
                                            title: 'No fue posible eliminar el beneficiario',
                                            text: response.post,
                                            icon: "error",
                                            button: "OK",
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    swal("Error", "No se pudo eliminar el beneficiario. Intente nuevamente.", "error");
                                }
                            });
                        }
                    });
                });


            });

            $(document).ready(function() {
                // Iterar sobre cada formulario de actualización
                $('[id^=beneficiaryUpdateForm]').on('submit', function(e) {
                    e.preventDefault();
                    let form = $(this);
                    let base_url = "<?php echo base_url(); ?>";

                    $.ajax({
                        url: form.attr('action'),
                        type: form.attr('method'),
                        data: form.serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                alert(response.message);
                                window.location.href = base_url + 'admin';
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function() {
                            alert('Error al actualizar el beneficiario. Intente nuevamente');
                        }
                    });
                });
            });

            function goToPage(pageNumber) {
                window.location.href = '<?= base_url("admin") ?>?page=' + pageNumber + '&search=<?= esc($search) ?>';
            }


            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('searchInput');
                const resultsContainer = document.getElementById('resultsContainer');

                if (!searchInput || !resultsContainer) {
                    console.error('Elementos de búsqueda no encontrados en el DOM.');
                    return;
                }

                // Debounce function to limit the rate of search queries
                function debounce(func, wait) {
                    let timeout;
                    return function(...args) {
                        clearTimeout(timeout);
                        timeout = setTimeout(() => func.apply(this, args), wait);
                    };
                }

                // Function to fetch search results
                function fetchResults(query) {
                    fetch('<?= base_url('admin') ?>?search=' + encodeURIComponent(query), {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.text())
                        .then(data => {
                            resultsContainer.innerHTML = data;
                        })
                        .catch(error => console.error('Error al buscar:', error));
                }

                // Attach event listener with debounce
                searchInput.addEventListener('keydown', debounce(function() {
                    const searchTerm = searchInput.value.trim();
                    if (searchTerm.length > 2) { // Solo busca si hay más de 2 caracteres
                        fetchResults(searchTerm);
                    } else {
                        resultsContainer.innerHTML = ''; // Limpiar resultados si la búsqueda está vacía
                    }
                }, 300)); // 300 ms de espera antes de realizar la búsqueda
            });
        </script>
</body>

</html>