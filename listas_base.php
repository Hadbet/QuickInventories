<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>GRAMMER INVENTARIO</title>

    <?php include 'estaticos/stylesEstandar.php'; ?>

    <link rel="stylesheet" href="css/generales.css">
</head>
<body class="vertical  light  ">
<div class="wrapper">
    <?php
    require_once('estaticos/navegador.php');
    ?>
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h2 class="mb-2 page-title">Lista de marbetes general</h2>
                    <div class="row my-4">
                        <!-- Small table -->
                        <div class="col-md-12">
                            <div class="card shadow">
                                <div class="card-body">
                                    <!-- table -->
                                    <table class="table datatables" id="dataTable-1">
                                        <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Número de Parte</th>
                                            <th>Primer Conteo</th>
                                            <th>Comentario</th>
                                            <th>StorageBin</th>
                                            <th>StorageType</th>
                                            <th>Usuario</th>
                                            <th>Estatus</th>
                                            <th>Boton</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Número de Parte</th>
                                            <th>Primer Conteo</th>
                                            <th>Comentario</th>
                                            <th>StorageBin</th>
                                            <th>StorageType</th>
                                            <th>Usuario</th>
                                            <th>Estatus</th>
                                            <th>Boton</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- simple table -->
                    </div> <!-- end section -->
                </div> <!-- .col-12 -->


                <div class="col-12">
                    <h2 class="mb-2 page-title">Numeros de parte faltantes por contar</h2>
                    <div class="row my-4">
                        <!-- Small table -->
                        <div class="col-md-12">
                            <div class="card shadow">
                                <div class="card-body">
                                    <!-- table -->
                                    <table class="table datatables" id="dataTable-2">
                                        <thead>
                                        <tr>
                                            <th>Número de Parte</th>
                                            <th>StorageBin</th>
                                            <th>StorageType</th>
                                            <th>Cantidad</th>
                                            <th>Mostrar</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>Número de Parte</th>
                                            <th>StorageBin</th>
                                            <th>StorageType</th>
                                            <th>Cantidad</th>
                                            <th>Mostrar</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- simple table -->
                    </div> <!-- end section -->
                </div> <!-- .col-12 -->

                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <button type="button" id="btnEntrar" style="display: none" class="btn mb-2 btn-outline-success" data-toggle="modal" data-target="#verticalModal"> Entrar </button>
                            <!-- Modal -->
                            <div class="modal fade" id="verticalModal" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="verticalModalTitle">Configuración</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="form-group mb-3">
                                                <label for="simpleinput">Folio</label>
                                                <input type="text" id="txtFolio" class="form-control" readonly>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="example-email">Numero Parte</label>
                                                <input type="text" id="txtNumeroParte" name="example-email" class="form-control" readonly>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="example-email">Cantidad</label>
                                                <input type="text" id="txtCantidad" name="example-email" class="form-control" readonly>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="example-email">StorageBin</label>
                                                <input type="text" id="txtStorageBin" name="example-email" class="form-control" readonly>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="example-email">Storage Type</label>
                                                <input type="text" id="txtStorageType" name="example-email" class="form-control" readonly>
                                            </div>

                                            <div id="tablaContainer">
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="btnModalClose" class="btn mb-2 btn-secondary" data-dismiss="modal">Cerrar</button>
                                            <button type="button" onclick="guardarConfiguracion();" id="btnGuardarModal" class="btn mb-2 btn-primary">Guardar cambios</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- .row -->
        </div> <!-- .container-fluid -->
    </main> <!-- main -->
</div> <!-- .wrapper -->

<?php include 'estaticos/scriptEstandar.php'; ?>

<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

<!-- JavaScript -->
<script src="lib/sweetalert2.all.min.js"></script>

<script>

    function buscarDatos(idBitacora) {
        // Obtener los valores de los inputs
        const numeroParte = document.getElementById('txtNumeroParte').value;
        const storageBin = document.getElementById('txtStorageBin').value;
        const storageType = document.getElementById('txtStorageType').value;

        // Mostrar loader mientras se carga la información
        const tablaContainer = document.getElementById('tablaContainer');
        tablaContainer.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="sr-only">Cargando...</span></div></div>';

        $.getJSON('https://grammermx.com/Logistica/QuickInventories/dao/consultaSun.php?storageBin='+storageBin+'&numeroParte='+numeroParte+'&storageType='+storageType, function(data) {
            // Limpiar el contenedor completamente
            tablaContainer.innerHTML = '';

            if (data && data.data && data.data.length > 0) {
                // Crear elementos de tabla desde cero
                const table = document.createElement('table');
                table.className = 'table table-bordered table-hover';
                table.id = 'tablaResultados';

                // Crear thead
                const thead = document.createElement('thead');
                thead.className = 'thead-light';
                thead.innerHTML = `
            <tr>
                <th>SUN</th>
                <th>Cantidad</th>
                <th>Contado</th>
            </tr>
        `;

                // Crear tbody
                const tbody = document.createElement('tbody');

                // Llenar la tabla con los datos
                for (var i = 0; i < data.data.length; i++) {
                    const item = data.data[i];
                    const row = document.createElement('tr');

                    // Celda SUN (Id_StorageUnit)
                    const cellSUN = document.createElement('td');
                    cellSUN.textContent = item.Id_StorageUnit || 'N/A';

                    // Celda Cantidad
                    const cellCantidad = document.createElement('td');
                    cellCantidad.textContent = item.Cantidad || '0';

                    // Celda Estatus con Checkbox
                    const cellEstatus = document.createElement('td');
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.className = 'estatus-checkbox';
                    checkbox.checked = item.Estatus == 1; // true si Estatus es 1

                    if (idBitacora===""){

                    }else {
                        checkbox.addEventListener('change', function() {
                            const SUN = this.closest('tr').cells[0].textContent;
                            const CANTIDADSUN = this.closest('tr').cells[1].textContent;
                            const nuevoEstado = this.checked;
                            var estatus;
                            console.log(`SUN: ${SUN}, Nuevo estado: ${nuevoEstado ? 'Contado' : 'No contado'}`);

                            if (nuevoEstado){
                                estatus = '1';
                                document.getElementById("txtCantidad").value = parseFloat(document.getElementById("txtCantidad").value) + parseFloat(CANTIDADSUN);
                            } else {
                                estatus = '0';
                                document.getElementById("txtCantidad").value = parseFloat(document.getElementById("txtCantidad").value) - parseFloat(CANTIDADSUN);
                            }

                            var formData = new FormData();
                            formData.append('estatus', estatus);
                            formData.append('marbete', document.getElementById("txtFolio").value);
                            formData.append('sun', SUN);

                            fetch('https://grammermx.com/Logistica/QuickInventories/dao/guardarConfiguracionSun.php', {
                                method: 'POST',
                                body: formData
                            })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error(`Error HTTP: ${response.status}`);
                                    }else{
                                        guardarConfiguracion();
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    if (!data) {
                                        throw new Error("Respuesta vacía del servidor");
                                    }
                                    if (!data.success) {
                                        console.error("Error en la operación:", data.message);
                                    }
                                })
                                .catch(error => {
                                    console.error("Error:", error.message);
                                    // Revertir cambios si falla
                                    this.checked = !nuevoEstado;
                                    document.getElementById("txtCantidad").value = parseFloat(document.getElementById("txtCantidad").value) + (nuevoEstado ? -parseFloat(CANTIDADSUN) : parseFloat(CANTIDADSUN));
                                });
                        }); // <-- ¡Esta llave estaba faltando!
                    }

                    cellEstatus.appendChild(checkbox);
                    row.appendChild(cellSUN);
                    row.appendChild(cellCantidad);
                    row.appendChild(cellEstatus);
                    tbody.appendChild(row);
                }

                // Ensamblar la tabla
                table.appendChild(thead);
                table.appendChild(tbody);

                // Crear contenedor responsive y añadir la tabla
                const tableResponsive = document.createElement('div');
                tableResponsive.className = 'table-responsive';
                tableResponsive.appendChild(table);

                // Añadir la tabla al contenedor
                tablaContainer.appendChild(tableResponsive);
            } else {
                // Mostrar mensaje si no hay datos
                tablaContainer.innerHTML = '<div class="alert alert-warning">No se encontraron resultados</div>';
            }
        }).fail(function(jqxhr, textStatus, error) {
            // Manejar errores de la petición
            tablaContainer.innerHTML = '<div class="alert alert-danger">Error al cargar los datos: ' + textStatus + '</div>';
            console.error("Error en la petición: ", textStatus, error);
        });
    }

    $.ajax({
        url: 'https://grammermx.com/Logistica/QuickInventories/dao/consultaAuditor.php', // Reemplaza esto con la URL de tus datos
        dataType: 'json',
        success: function(data) {
            var table = $('#dataTable-1').DataTable({
                data: data.data,
                columns: [
                    { data: 'Id_Bitacora' },
                    { data: 'NumeroParte' },
                    { data: 'PrimerConteo' },
                    { data: 'Comentario' },
                    { data: 'StorageBin' },
                    { data: 'StorageType' },
                    { data: 'Usuario' },
                    { data: 'Estatus' },
                    { data: 'Boton' }
                ],
                autoWidth: true,
                "lengthMenu": [
                    [16, 32, 64, -1],
                    [16, 32, 64, "All"]
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        className: 'btn btn-sm copyButton'
                    },
                    {
                        extend: 'csv',
                        className: 'btn btn-sm csvButton'
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-sm excelButton'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-sm pdfButton'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-sm printButton'
                    }
                ],
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        var input = document.createElement("input");
                        input.className = 'form-control form-control-sm';
                        $(input).appendTo($(column.footer()).empty())
                            .on('keyup change clear', function () {
                                if (column.search() !== this.value) {
                                    column.search(this.value).draw();
                                }
                            });
                    });
                }
            });
        }
    });

    $.ajax({
        url: 'https://grammermx.com/Logistica/QuickInventories/dao/consultaFaltantesSun.php', // Reemplaza esto con la URL de tus datos
        dataType: 'json',
        success: function(data) {
            var table = $('#dataTable-2').DataTable({
                data: data.data,
                columns: [
                    { data: 'GrammerNo' },
                    { data: 'STBin' },
                    { data: 'STType' },
                    { data: 'Cantidad' },
                    { data: 'Boton' }
                ],
                autoWidth: true,
                "lengthMenu": [
                    [16, 32, 64, -1],
                    [16, 32, 64, "All"]
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        className: 'btn btn-sm copyButton'
                    },
                    {
                        extend: 'csv',
                        className: 'btn btn-sm csvButton'
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-sm excelButton'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-sm pdfButton'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-sm printButton'
                    }
                ],
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        var input = document.createElement("input");
                        input.className = 'form-control form-control-sm';
                        $(input).appendTo($(column.footer()).empty())
                            .on('keyup change clear', function () {
                                if (column.search() !== this.value) {
                                    column.search(this.value).draw();
                                }
                            });
                    });
                }
            });
        }
    });

    function llenarDatos(idBitacora,numeroParte,comentario,primerConteo,storageBin,storageTipe) {

        if (idBitacora===""){
            document.getElementById("btnGuardarModal").style.display = "none";
        }else{
            document.getElementById("btnGuardarModal").style.display = "block";
        }

        document.getElementById("txtFolio").value = idBitacora;
        document.getElementById("txtNumeroParte").value = numeroParte;
        document.getElementById("txtCantidad").value = primerConteo;
        document.getElementById("txtStorageBin").value = storageBin;
        document.getElementById("txtStorageType").value = storageTipe;
        document.getElementById("btnEntrar").click();
        buscarDatos(idBitacora);
    }

    function guardarConfiguracion() {

        var formData = new FormData();
        formData.append('cantidad', document.getElementById("txtCantidad").value);
        formData.append('marbete', document.getElementById("txtFolio").value);

        fetch('https://grammermx.com/Logistica/QuickInventories/dao/guardarConfiguracion.php', {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error HTTP: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (!data) {
                    throw new Error("Respuesta vacía del servidor");
                }
                if (!data.success) {
                    console.error("Error en la operación:", data.message);
                }else{
                    console.log("Terminado");
                }
            })
            .catch(error => {
                console.error("Error:", error.message);
                // Revertir cambios si falla
                this.checked = !nuevoEstado;
                document.getElementById("txtCantidad").value = parseFloat(document.getElementById("txtCantidad").value) + (nuevoEstado ? -parseFloat(CANTIDADSUN) : parseFloat(CANTIDADSUN));
            });

    }
</script>
<script src="js/apps.js"></script>
<script>
    function verFormato(curso,horario,fecha) {
        var link = "https://grammermx.com/RH/Cursos/pruebaPDF.php?curso="+curso+"&horario="+horario+"&fecha="+fecha;
        window.open(link, '_blank');
    }
</script>
</body>
</html>