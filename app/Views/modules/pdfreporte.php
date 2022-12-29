<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Document</title>

    <!-- Milligram CSS Framework :D -->
    <style type="text/css">
        <?= $this->include('modules/milligram') ?>
    </style>

    <style type="text/css">
        body {
            color: black;
            font-size: 1.1em;
        }

        td,
        th {
            padding: 1.0rem 1.2rem;
        }

        .td-border {
            border-bottom: 0.1rem solid black;
            border-top: 0.1rem solid black;
        }

        .text-center {
            text-align: center;
        }
    </style>

</head>

<body>
    <section class="invoice">
        <h4 class="text-center">
            REPORTE PLANILLA - HABERES DESDE <?php echo ($desde === null ? 'INICIO' : $desde['nombre_year']) ?> HASTA <?php echo ($hasta === null ? 'LA ACTUALIDAD' : $hasta['nombre_year']) ?>
        </h4>

        <div class="container">
            <div class="row">
                <div class="column">
                    <p> S.M. TRANSP. DRTC-SM </p>
                </div>
            </div>

            <div class="row">
                <div class="column">
                    <div class="float-left">
                        <p> NRO RUC: 20178677684 </p>
                    </div>

                    <div class="float-right">
                        <p> FECHA: <?= date('Y-m-d H:i:s') ?> </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <br />
            <br />
            <br />
        </div>

        <div class="container">
            <div class="row">
                <div class="column">
                    <p> 200.9001.3999999.5000006.15.006.0012 0025 CONTROL Y AUDITORIA </p>
                </div>
            </div>

            <div class="row">
                <div class="column">
                    <p> DEPENDENCIA: 0000000000330000 CONTROL Y AUDITORIA </p>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="column">
                    <table>
                        <thead>
                            <tr>
                                <th> ATRIBUTOS </th>
                                <th> TRABAJADOR </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nombres</td>
                                <td><?= $personal['nombre_personal'] ?></td>
                            </tr>

                            <tr>
                                <td>Apellidos</td>
                                <td><?= $personal['apellido_personal'] ?></td>
                            </tr>

                            <tr>
                                <td>Nro. Cuenta</td>
                                <td><?= $personal['nro_cuenta'] ?></td>
                            </tr>

                            <tr>
                                <td>Reg. Pens</td>
                                <td><?= $personal['nombre_regimen'] ?></td>
                            </tr>

                            <tr>
                                <td>Cond. Lab</td>
                                <td><?= $personal['condicion'] ?></td>
                            </tr>

                            <tr>
                                <td>Nivel Rem.</td>
                                <td><?= $personal['nivel'] ?></td>
                            </tr>

                            <tr>
                                <td>Cargo Estructural</td>
                                <td><?= $personal['nombre_cargo'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="column">
                    <table>
                        <thead>
                            <tr>
                                <th> ATRIBUTOS </th>
                                <th> MONTO </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bonificaciones as $bonificacion) { ?>
                                <tr>
                                    <td> <?= $bonificacion['nombre_bonificacion'] ?> </td>
                                    <td> <?= $totales[$bonificacion['nombre_bonificacion']] ?></td>
                                </tr>
                            <?php } ?>
                            <tr class="tr-border">
                                <td class="td-border">TOTAL INGRESO</td>
                                <td class="td-border"> <?= $totales['total_ingreso'] ?> </td>
                            </tr>
                            <?php foreach ($descuentos as $descuento) { ?>
                                <tr>
                                    <td> <?= $descuento['nombre_descuento'] ?> </td>
                                    <td> <?= $totales[$descuento['nombre_descuento']] ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td class="td-border">TOTAL EGRESO</td>
                                <td class="td-border"> <?= $totales['total_egreso'] ?> </td>
                            </tr>
                            <tr>
                                <td class="h6 td-border">TOTAL NETO</td>
                                <td class="td-border"> <?= $totales['total_neto'] ?> </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </section>
</body>

</html>
