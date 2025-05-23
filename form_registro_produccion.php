
<?php
session_start();
$rol =$_SESSION['rol'];
$area =$_SESSION['area'];
$areaNombre =$_SESSION['AreaNombre'];
$bin =$_SESSION['StBin'];
$nomina =$_SESSION['nomina'];
$nombre =$_SESSION['nombre'];

if (strlen($nomina) == 1) {
    $nomina = "0000000" . $nomina;
}
if (strlen($nomina) == 2) {
    $nomina = "000000" . $nomina;
}
if (strlen($nomina) == 3) {
    $nomina = "00000" . $nomina;
}
if (strlen($nomina) == 4) {
    $nomina = "0000" . $nomina;
}
if (strlen($nomina) == 5) {
    $nomina = "000" . $nomina;
}
if (strlen($nomina) == 6) {
    $nomina = "00" . $nomina;
}
if (strlen($nomina) == 7) {
    $nomina = "0" . $nomina;
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>GRAMMER INVENTARIO</title>

    <?php include 'estaticos/stylesEstandar.php'; ?>
    <!-- JavaScript -->
    <script src="lib/sweetalert2.all.min.js"></script>

    <link rel="stylesheet" href="css/generales.css">

</head>
<body class="vertical  light  ">
<div class="wrapper">

    <?php
            require_once('estaticos/navegador.php');
    ?>

    <main role="main" class="main-content">
        <center><img src="images/tituloInventario.png" style="width: 50%"></center>
        <br><br>

        <div class="container-fluid" id="pasoUno">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h2 class="page-title">Paso 1 : Escaneo de marbete</h2>
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <strong class="card-title">Captura</strong>
                        </div>
                        <div class="card-body">
                            <div class="row">
                               <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <input type="number" class="form-control"
                                                   id="scanner_input" autocomplete="off">
                                            <br>
                                       </div>
                                    </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn mb-2 btn-success float-right text-white" onclick="manualMarbete()">Siguiente<span
                                    class="fe fe-chevron-right fe-16 ml-2"></span></button>
                        </div>
                    </div> <!-- / .card -->
                </div> <!-- .col-12 -->
            </div> <!-- .row -->
        </div> <!-- .container-fluid -->

        <div class="container-fluid" id="pasoDos" style="display: none">
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <p class="mb-3"><strong>Captura</strong></p>

                            <label for="basic-url">Número de parte</label>
                            <div class="input-group mb-3">
                                <input type="text" id="txtNumeroParte" class="form-control" autocomplete="off"  aria-label="Recipient's username" aria-describedby="button-addon2">
                            </div>

                            <label for="basic-url">Cantidad</label>
                            <div class="input-group mb-3">
                                <input type="number" id="txtCantidad" disabled class="form-control" aria-label="Recipient's username" autocomplete="off" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="txtUnidadMedida" style=""></span>
                                </div>
                            </div>

                            <label for="basic-url">Storage Bin</label>
                            <div class="input-group mb-3">
                                <input type="text" id="txtStorageBin" disabled class="form-control" aria-label="Recipient's username" autocomplete="off" aria-describedby="basic-addon2">
                            </div>

                        </div>
                    </div>
                </div> <!-- /.col -->

                <div class="col-md-6 col-xl-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header">
                            <span class="card-title">Marbete : <span id="lblFolio"></span></span>
                            <a class="float-right small text-muted" href="#!"><i class="fe fe-more-vertical fe-12"></i></a>
                        </div>
                        <div class="card-body my-n2">
                            <div class="d-flex">
                                <div class="flex-fill">
                                    <span class="card-title">Número de parte</span>
                                    <h4 class="mb-0" id="lblNumeroParte"></h4>
                                </div>
                                <div class="flex-fill text-right">
                                    <p class="mb-0 small" id="lblCosto"></p>
                                    <p class="text-muted mb-0 small">Pesos</p>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex">
                                <div class="flex-fill">
                                    <span class="card-title">Cantidad</span>
                                    <h4 class="mb-0" id="lblCantidad"> <span id="lblUm"></span></h4>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex">
                                <div class="flex-fill">
                                    <span class="card-title">Descripción</span>
                                    <h4 class="mb-0" id="lblDescripcion"></h4>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex">
                                <div class="flex-fill">
                                    <span class="card-title">Storage Bin</span>
                                    <h4 class="mb-0" id="lblStorageBin"></h4>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex">
                                <div class="flex-fill">
                                    <span class="card-title">Storage Type</span>
                                    <h4 class="mb-0" id="lblStorageType"></h4>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex">
                                <div class="flex-fill">
                                    <span class="card-title">Valor monetario conteo</span>
                                    <h4 class="mb-0" id="lblMontoTotal"></h4>
                                </div>
                            </div>
                            <hr>
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <a href="#" class="avatar avatar-md">
                                        <img src="https://grammermx.com/Fotos/<?php echo $nomina; ?>.png" alt="..." class="avatar-img rounded-circle">
                                    </a>
                                </div>
                                <div class="col ml-n2">
                                    <strong class="mb-1" id="lblNombre"><?php echo $nombre; ?></strong><span class="dot dot-lg bg-success ml-1"></span>
                                    <p class="small text-muted mb-1" id="lblRol">Capturista</p>
                                </div>
                            </div>
                            <hr>
                            <label for="basic-url">Comentarios</label>
                            <div class="input-group mb-3">
                                <input type="text" id="txtComentarios" autocomplete="off" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2">
                            </div>
                            <button id="btnFin" disabled class="btn mb-2 btn-success float-right text-white" onclick="enviarDatos()">Finalizar Captura<span
                                        class="fe fe-chevron-right fe-16 ml-2" ></span></button>
                        </div> <!-- .card-body -->
                    </div> <!-- .card -->
                </div> <!-- .col -->

            </div> <!-- .row -->
        </div> <!-- .container-fluid -->

    </main> <!-- main -->

</div> <!-- .wrapper -->

<?php include 'estaticos/scriptEstandar.php'; ?>

<script src="js/apps.js"></script>
<script src="assets/scanapp.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<script>

    document.getElementById("txtStorageBin").value = '<?php echo $bin; ?>';
    document.getElementById("lblStorageBin").innerText = '<?php echo $bin;?>';
    document.getElementById('scanner_input').focus();

    var typeGlobal;

    var auxConteo=0;
    var auxStorage=0;
    estatusConteo();
    function estatusConteo() {
        $.getJSON('https://grammermx.com/Logistica/QuickInventories/dao/consultaAreaDetalle.php?area=<?php echo $area;?>', function (data) {
            for (var i = 0; i < data.data.length; i++) {
                auxConteo = data.data[i].Conteo;
                auxStorage = data.data[i].StBin

            }
        });
    }



    function buscarType() {
        $.getJSON('https://grammermx.com/Logistica/QuickInventories/dao/consultaTypes.php?bin=<?php echo $bin;?>', function (data) {
            if (data.data.length > 0) {
                for (var i = 0; i < data.data.length; i++) {
                    typeGlobal=data.data[i].StType;
                    document.getElementById('lblStorageType').innerText = typeGlobal;
                }
            } else {
                console.log('No data received');
            }
        });
    }
    function validarUbicacion(numeroParteU,descripcionU,umU,costoUnitarioU) {
        $.getJSON('https://grammermx.com/Logistica/QuickInventories/dao/consultaUbicacionProduccion.php?numeroParte='+numeroParteU+'&bin=<?php echo $bin;?>', function (data) {
            if (data && data.data && data.data.length > 0) {
                for (var i = 0; i < data.data.length; i++) {
                    if (data.data[i].PVB === '<?php echo $bin;?>') {
                        document.getElementById('lblDescripcion').innerText = descripcionU;
                        document.getElementById('txtUnidadMedida').innerText = umU;
                        document.getElementById('lblCosto').innerText = costoUnitarioU.toFixed(2);
                        document.getElementById('txtCantidad').disabled = false;
                        document.getElementById('txtCantidad').focus()

                        var txtCantidad = document.getElementById('txtCantidad');

                        if (umU === 'PC') {
                            txtCantidad.addEventListener('keypress', function(e) {
                                var charCode = (e.which) ? e.which : e.keyCode;
                                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                                    e.preventDefault();
                                }
                            });
                        } else {
                            // Permite números decimales
                            txtCantidad.removeEventListener('keypress');
                        }

                        bandera=1;
                    } else {
                        bandera=0;
                        Swal.fire({
                            title: "El numero de parte no existe en esa ubicacion",
                            text: "Verificalo con la mesa de control",
                            icon: "error"
                        });
                    }
                }
            } else {
                Swal.fire({
                    title: "El numero de parte no pertenece a esta ubicacion",
                    text: "Verificalo con la mesa de control",
                    icon: "error"
                });
            }
        });
    }



    var costoUnitario=0;
    var bandera=0;

    document.getElementById('txtNumeroParte').addEventListener('keyup', function(event) {
        this.value = this.value.toUpperCase();
        var inputValue = this.value;
        document.getElementById('lblNumeroParte').textContent = inputValue;
        if (event.key === 'Enter' || event.keyCode === 13) {
            $.getJSON('https://grammermx.com/Logistica/QuickInventories/dao/consultaParte.php?parte='+this.value, function (data) {
                if (data && data.data && data.data.length > 0) {
                    for (var i = 0; i < data.data.length; i++) {
                        if (data.data[i].GrammerNo) {
                            costoUnitario = data.data[i].Costo / data.data[i].Por;
                            validarUbicacion(data.data[i].GrammerNo,data.data[i].Descripcion,data.data[i].UM,costoUnitario);
                        } else {
                            bandera=0;
                            Swal.fire({
                                title: "El numero de parte no existe",
                                text: "Verificalo con la mesa de control",
                                icon: "error"
                            });
                        }
                    }
                }else{
                    Swal.fire({
                        title: "El numero de parte no existe en base",
                        text: "Verificalo con la mesa de control",
                        icon: "error"
                    });
                }

            });

        }
    });

    // Cuando se suelta una tecla en el campo de entrada de la cantidad
    document.getElementById('txtCantidad').addEventListener('keyup', function(event) {
        if (event.key === '-') {
            document.getElementById('txtCantidad').value = '';
        }
        // Si la tecla fue Enter
        document.getElementById('lblCantidad').textContent = this.value;
        var result = costoUnitario * this.value;
        document.getElementById('lblMontoTotal').innerText = result.toFixed(2);
        if (event.key === 'Enter' || event.keyCode === 13) {
            document.getElementById('lblCantidad').textContent = this.value;
            if (document.getElementById('txtCantidad').value===document.getElementById('txtNumeroParte').value){
                Swal.fire({
                    title: "Estas ingresando el numero de parte en la cantidad",
                    text: "Verifica antes de entrar",
                    icon: "error"
                });
            }else{
                if (document.getElementById('txtCantidad').value!==""){
                    if (document.getElementById('txtStorageBin').value!==""){
                        if (bandera!=="0"){
                            document.getElementById('btnFin').disabled = false;
                            document.getElementById("btnFin").scrollIntoView({behavior: "smooth"});
                            //document.getElementById("btnFin").focus();
                            Swal.fire({
                                title: "¿Deseas guardar la captura? Si es así, presiona 'Enter'.",
                                showDenyButton: true,
                                showCancelButton: true,
                                confirmButtonText: "Guardar",
                                denyButtonText: "Verificar datos"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    enviarDatos();
                                    resolve(true);
                                } else if (result.isDenied) {
                                    Swal.fire("Por favor, tómate tu tiempo para verificar los datos. Recuerda, cuando hayas terminado, haz clic en el botón verde 'Finalizar'.", "", "info");
                                    resolve(false);
                                }
                            });

                        }else{
                            Swal.fire({
                                title: "No haz validado el NP",
                                text: "Verifica antes de entrar",
                                icon: "error"
                            });
                        }
                    }else{
                        Swal.fire({
                            title: "Ingresa el storage bin",
                            text: "Verifica antes de entrar",
                            icon: "error"
                        });
                    }
                }else{
                    Swal.fire({
                        title: "Ingresa la cantidad",
                        text: "Verifica antes de entrar",
                        icon: "error"
                    });
                }
            }
        }
    });

    // Cuando se suelta una tecla en el campo de entrada del storage bin
    document.getElementById('txtStorageBin').addEventListener('keyup', function(event) {
        // Si la tecla fue Enter
        document.getElementById('lblStorageBin').textContent = this.value;
        if (event.key === 'Enter' || event.keyCode === 13) {
            // Actualiza el texto del elemento lblStorageBin
            document.getElementById('lblStorageBin').textContent = this.value;

            if (document.getElementById('txtCantidad').value!==""){
                if (document.getElementById('txtStorageBin').value!==""){
                    if (bandera!=="0"){
                        document.getElementById('btnFin').disabled = false;
                    }else{
                        Swal.fire({
                            title: "No haz validado el NP",
                            text: "Verifica antes de entrar",
                            icon: "error"
                        });
                    }
                }else{
                    Swal.fire({
                        title: "Ingresa el storage bin",
                        text: "Verifica antes de entrar",
                        icon: "error"
                    });
                }
            }else{
                Swal.fire({
                    title: "Ingresa la cantidad",
                    text: "Verifica antes de entrar",
                    icon: "error"
                });
            }
        }
    });

    var numeroParte;
    var storageBin;

    var numeroParteUnit;
    var cantidad;

    function manualMarbete() {

        var marbete = parseInt(document.getElementById("scanner_input").value.split('.')[0], 10);

        if (document.getElementById("scanner_input").value.split('.')[1] === auxConteo){
            $.getJSON('https://grammermx.com/Logistica/QuickInventories/dao/consultaMarbete.php?marbete='+marbete, function (data) {
                if (data && data.data && data.data.length > 0) {
                    for (var i = 0; i < data.data.length; i++) {
                        if (data.data[i].FolioMarbete) {
                            if (data.data[i].Estatus === '0'){
                                if (data.data[i].Area === '<?php echo $area;?>'){
                                    numeroParte=data.data[i].NumeroParte;
                                    document.getElementById("lblFolio").innerHTML = marbete;
                                    document.getElementById("pasoDos").style.display = 'block';
                                    document.getElementById("pasoUno").style.display = 'none';
                                    document.getElementById('txtNumeroParte').focus();
                                    buscarType();
                                }else{
                                    Swal.fire({
                                        title: "El marbete no pertenece al area",
                                        text: "Escanea otro marbete",
                                        icon: "error"
                                    });
                                }
                            }else{
                                Swal.fire({
                                    title: "El marbete ya fue registrado",
                                    text: "Escanea otro marbete",
                                    icon: "error"
                                });
                            }
                        } else {
                            Swal.fire({
                                title: "El marbete no esta cargado",
                                text: "Verificalo con la mesa central",
                                icon: "error"
                            });
                        }
                    }
                }else{
                    Swal.fire({
                        title: "El marbete ingresado no existe",
                        text: "Escanea otro marbete",
                        icon: "error"
                    });
                }

            });
        }else{
            Swal.fire({
                title: "El marbete no pertenece al conteo: "+auxConteo,
                text: "Escanea el correcto",
                icon: "error"
            });
        }


    }


    function enviarDatos() {

        var marbete = document.getElementById("scanner_input").value
        var nombre = document.getElementById("lblNombre").innerText;
        var comentarios = document.getElementById("txtComentarios").value;
        var numeroParte = document.getElementById("txtNumeroParte").value;
        var cantidad = document.getElementById("txtCantidad").value;
        var storageBin = document.getElementById("txtStorageBin").value;

        var formData = new FormData();
        formData.append('nombre', '<?php echo $nomina;?>-'+nombre);
        formData.append('comentarios', comentarios);
        formData.append('folioMarbete', marbete);
        formData.append('numeroParte', numeroParte);
        formData.append('cantidad', parseFloat(cantidad));
        formData.append('storageBin', storageBin);
        formData.append('storageType', typeGlobal);

        fetch('https://grammermx.com/Logistica/QuickInventories/dao/guardarMarbeteProduccion.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let timerInterval;
                    Swal.fire({
                        title: "¡Gracias!.Se finalizo la captura de tu marbete",
                        html: "Te regresaremos a la pagina <b></b> milliseconds.",
                        timer: 1500,
                        timerProgressBar: true,
                        icon: "success",
                        didOpen: () => {
                            Swal.showLoading();
                            const timer = Swal.getPopup().querySelector("b");
                            timerInterval = setInterval(() => {
                                timer.textContent = `${Swal.getTimerLeft()}`;
                            }, 100);
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                        }
                    }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                            location.reload();
                        }
                    });
                } else {
                    console.log("Hubo un error en la operación");
                    console.log("Las unidades de almacenamiento que fallaron son: ", data.failedUnits);
                }
            });
    }

    document.getElementById('scanner_input').addEventListener('keyup', function(event) {
        if (event.key === 'Enter' || event.keyCode === 13) {
            manualMarbete();
        }
    });

</script>
</body>
</html>