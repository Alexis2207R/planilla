<?php

namespace App\Controllers;

use App\Models\BonificacionModel;
use App\Models\DescuentoModel;
use App\Models\PagoBonificacionModel;
use App\Models\PagoDescuentoModel;
use App\Models\PagoModel;
use App\Models\PersonalModel;
use App\Models\YearModel;
use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class PorPersonas extends Controller
{
    public function __construct()
    {
        $this->modPersonal         = new PersonalModel();
        $this->modBonificacion     = new BonificacionModel();
        $this->modDescuento        = new DescuentoModel();
        $this->modYear             = new YearModel();
        $this->modPago             = new PagoModel();
        $this->modPagoDescuento    = new PagoDescuentoModel();
        $this->modPagoBonificacion = new PagoBonificacionModel();
    }

    public function index()
    {
        $personales = $this->modPersonal->getAllActive();
        $bonificaciones = $this->modBonificacion->getAllActive();
        $descuentos = $this->modDescuento->getAllActive();
        $years = $this->modYear->getAllActive();
        $data = [
            'personales'     => $personales,
            'bonificaciones' => $bonificaciones,
            'descuentos'     => $descuentos,
            'years'          => $years
        ];
        return $this->ViewData('modules/porpersona', $data);
    }

    public function search_porpersona()
    {
        if ($this->request->isAjax())
        {
            $idPersonal = $_POST['id_personal'];
            if (!isset($_POST['id_year']) && !isset($_POST['id_year2']))
                $pagos = $this->modPago->mdListarDePersonaPorTodo($idPersonal);
            else if (isset($_POST['id_year']) && isset($_POST['id_year2']))
            {
                $inicio = $_POST['id_year'];
                $fin = $_POST['id_year2'];
                $years = $this->modYear->getAllActive();
                $saveYear = false;
                $idYears = [];
                // NOTE: Los anios deben estar ordenados en la base de datos para que esto funcione
                foreach ($years as $year)
                {
                    if ($year['id_year'] == $fin)
                    {
                        array_push($idYears, $year['id_year']);
                        break;
                    }
                    if ($year['id_year'] == $inicio)
                        $saveYear = true;
                    if ($saveYear == true)
                        array_push($idYears, $year['id_year']);
                }
                $pagos = $this->modPago->mdListarDePersonaPorAnios($idPersonal, $idYears);
            }
            else
            {
                return json_encode(['status' => 400, 'msg' => 'Seleccione una fecha válida']);
            }

            $bonificaciones = $this->modBonificacion->getAllActive();
            $descuentos = $this->modDescuento->getAllActive();

            $reporte = $this->getReporteFormatSearch($pagos, $bonificaciones, $descuentos);

            return json_encode(['status' => 200, 'reporte' => $reporte, 'bonificaciones' => $bonificaciones, 'descuentos' => $descuentos]);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function excel()
    {
        if ($this->request->isAjax()) {
            $idPersonal = $_POST['id_personal'];
            $years = [];
            if (isset($_POST['id_year']) && isset($_POST['id_year2']))
            {
                $inicio = $_POST['id_year'];
                $fin = $_POST['id_year2'];
                $allYears = $this->modYear->getAllActive();
                $saveYear = false;
                // NOTE: Los anios deben estar ordenados en la base de datos para que esto funcione
                foreach ($allYears as $year) {
                    if ($year['id_year'] == $fin) {
                        array_push($years, $year);
                        break;
                    }
                    if ($year['id_year'] == $inicio)
                        $saveYear = true;
                    if ($saveYear == true)
                        array_push($years, $year);
                }
            }
            else if (!isset($_POST['id_year']) && !isset($_POST['id_year2']))
            {
                $years = $this->modYear->getAllActive();
            }
            else
            {
                return; // NOTE: Enviar algun mensaje!...y debera programarlo para recibirlo
            }

            $bonificaciones = $this->modBonificacion->getAllActive();
            $descuentos = $this->modDescuento->getAllActive();
            $personal = $this->modPersonal->find($idPersonal);

            //$fileName = 'reporte.xlsx';
            $fileName = $personal['nombre_personal'] . ' ' . $personal['apellido_personal'] . '.xlsx';

            $excel = new Spreadsheet();
            $sheet = $excel->getActiveSheet();

            // Titulo
            $sheet->setCellValue('H1', 'SEÑOR JEFE DE LA UNIDAD DE PERSONAL DE LA DRTC - SM');
            $sheet->setCellValue('G2', 'A CONTINUACIÓN SE EXPIDE EL RECORD POR TIEMPO DE SERVICIOS DE: ');
            $sheet->setCellValue('H3', $personal['nombre_personal'] . ' ' . $personal['apellido_personal']);

            // Encabezado
            $rowEncabezado = 4; // La fila del encabezado
            $sheet->setCellValue('A' . $rowEncabezado, 'MES / AÑO');
            $sheet->setCellValue('B' . $rowEncabezado, 'NRO PLANILLA');
            $sheet->setCellValue('C' . $rowEncabezado, 'DIAS');
            $lastLetter = ord('D');
            foreach ($bonificaciones as $bonificacion) {
                $sheet->setCellValue(chr($lastLetter) . $rowEncabezado, $bonificacion['nombre_bonificacion']);
                $lastLetter++;
            }
            $sheet->setCellValue(chr($lastLetter) . $rowEncabezado, 'INGRESO');
            $lastLetter++;
            foreach ($descuentos as $descuento) {
                $sheet->setCellValue(chr($lastLetter) . $rowEncabezado, $descuento['nombre_descuento']);
                $lastLetter++;
            }
            $sheet->setCellValue(chr($lastLetter) . $rowEncabezado, 'EGRESO');
            $lastLetter++;
            $sheet->setCellValue(chr($lastLetter) . $rowEncabezado, 'TOTAL NETO');
            $lastLetter++;
            // Todo el titulo y encabezado en negrita
            $sheet->getStyle('A1:' . chr($lastLetter) . $rowEncabezado)->getFont()->setBold(true);

            // Cuerpo
            $row = $rowEncabezado + 1; // La fila del cuerpo del reporte
            foreach ($years as $year)
            {
                $pagos = $this->modPago->mdListarDePersonaPorAnio($idPersonal, $year['id_year']);

                $reporte = [];
                foreach ($pagos as $data)
                {
                    // NOTE: Estos nombres deben ser igual al de la cabecera del excel
                    $realData = [
                        'MES / AÑO'      => $data['nombre_mes'],
                        'NRO PLANILLA'    => $data['numero_planilla'],
                        'DIAS'            => $data['dias'],
                        'nombre_year'     => $data['nombre_year'],
                        'id_pago'         => $data['id_pago'],
                        'EGRESO'          => $data['total_egreso'],
                        'INGRESO'         => $data['total_ingreso'],
                        'TOTAL NETO'      => $data['total_neto'],
                    ];

                    foreach ($bonificaciones as $bonificacion)
                        $realData[$bonificacion['nombre_bonificacion']] = '';
                    foreach ($descuentos as $descuento)
                        $realData[$descuento['nombre_descuento']] = '';

                    $actualDescuentos = $this->modPagoDescuento->mdVerDePago($data['id_pago']);
                    foreach ($actualDescuentos as $actual)
                        $realData[$actual['nombre_descuento']] = $actual['cantidad_pago_descuento'];

                    $actualBonificaciones = $this->modPagoBonificacion->mdVerDePago($data['id_pago']);
                    foreach ($actualBonificaciones as $actual)
                        $realData[$actual['nombre_bonificacion']] = $actual['cantidad_pago_bonificacion'];

                    array_push($reporte, $realData);
                }

                $sheet->setCellValue('A' . $row, $year['nombre_year']);
                $sheet->getStyle('A' . $row)->getFont()->setBold(true);
                $row++;

                foreach ($reporte as $pago)
                {
                    $letter = ord('A');

                    // Si por algo falla!..resta aqui en la condicion
                    for ($i = 0; $i < count($pago) - 2; $i++)
                    {
                        $indice = $sheet->getCell(chr($letter) . $rowEncabezado)->getValue();
                        $sheet->setCellValue(chr($letter) . $row, $pago[$indice]);
                        $letter++;
                    }
                    $row++;
                }
                $row++; // El espacion entre years
            }

            $writer = new Xlsx($excel);
            ob_start();
            $writer->save('php://output');
            $dataExcel = ob_get_contents();
            ob_end_clean();

            $data = [
                'name' => $fileName,
                'file' => 'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,' . base64_encode($dataExcel)
            ];

            return $this->response->setJSON($data);
        }
    }

    public function pdf()
    {
        if ($this->request->isAjax())
        {
            $idPersonal = $_POST['id_personal'];
            if (isset($_POST['id_year']) && isset($_POST['id_year2']))
            {
                $inicio = $_POST['id_year'];
                $fin = $_POST['id_year2'];
                $years = $this->modYear->getAllActive();
                $saveYear = false;
                $idYears = [];
                // NOTE: Los anios deben estar ordenados en la base de datos para que esto funcione
                foreach ($years as $year)
                {
                    if ($year['id_year'] == $fin)
                    {
                        array_push($idYears, $year['id_year']);
                        break;
                    }
                    if ($year['id_year'] == $inicio)
                        $saveYear = true;
                    if ($saveYear == true)
                        array_push($idYears, $year['id_year']);
                }
                $pagos = $this->modPago->mdListarDePersonaPorAnios($idPersonal, $idYears);
                $desde = $this->modYear->find($_POST['id_year']);
                $hasta = $this->modYear->find($_POST['id_year2']);

            }
            else if (!isset($_POST['id_year']) && !isset($_POST['id_year2']))
            {
                $pagos = $this->modPago->mdListarDePersonaPorTodo($idPersonal);
                $desde = null;
                $hasta = null;
            }
            else
            {
                return json_encode(['status' => 400, 'msg' => 'Seleccione una fecha válida']);
            }

            $bonificaciones = $this->modBonificacion->getAllActive();
            $descuentos = $this->modDescuento->getAllActive();

            $reporte = $this->getReporteFormatSearch($pagos, $bonificaciones, $descuentos);
            $totales = [];

            foreach ($bonificaciones as $bonificacion)
                $totales[$bonificacion['nombre_bonificacion']] = 0.0;
            foreach ($descuentos as $descuento)
                $totales[$descuento['nombre_descuento']] = 0.0;
            $totales['total_egreso'] = 0.0;
            $totales['total_ingreso'] = 0.0;
            $totales['total_neto'] = 0.0;

            // Sumar todos los totales
            foreach ($reporte as $pago)
            {
                foreach ($bonificaciones as $bonificacion)
                    $totales[$bonificacion['nombre_bonificacion']] += floatval($pago[$bonificacion['nombre_bonificacion']]);
                foreach ($descuentos as $descuento)
                    $totales[$descuento['nombre_descuento']] += floatval($pago[$descuento['nombre_descuento']]);
                $totales['total_egreso']  += floatval($pago['total_egreso']);
                $totales['total_ingreso'] += floatval($pago['total_ingreso']);
                $totales['total_neto']    += floatval($pago['total_neto']);
            }

            $personal = $this->modPersonal->mdListarPersonal($idPersonal);
            $personal = $personal[0];

            $dataPDF = [
                'personal'       => $personal,
                'totales'        => $totales,
                'desde'          => $desde,
                'hasta'          => $hasta,
                'bonificaciones' => $bonificaciones,
                'descuentos'     => $descuentos
            ];

            $html = view('modules/pdfreporte', $dataPDF);

            //$fileName = 'reporte.pdf';
            $fileName = $personal['nombre_personal'] . ' ' . $personal['apellido_personal'] . '.pdf';

            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'landscape');
            // Render the HTML as PDF
            $dompdf->render();
            // Output the generated PDF to variable and return it to save it into the file
            $file = $dompdf->output();

            $data = [
                'name' => $fileName,
                'file' => 'data:application/pdf;base64,' . base64_encode($file)
            ];

            return $this->response->setJSON($data);
        }
    }

    private function getReporteFormatSearch($pagos, $bonificaciones, $descuentos)
    {
        $reporte = [];
        foreach ($pagos as $data) {
            $realData = [
                'nombre_mes'      => $data['nombre_mes'],
                'numero_planilla' => $data['numero_planilla'],
                'dias'            => $data['dias'],
                'nombre_year'     => $data['nombre_year'],
                'id_pago'         => $data['id_pago'],
                'total_egreso'    => $data['total_egreso'],
                'total_ingreso'   => $data['total_ingreso'],
                'total_neto'      => $data['total_neto'],
            ];

            foreach ($bonificaciones as $bonificacion)
                $realData[$bonificacion['nombre_bonificacion']] = '';
            foreach ($descuentos as $descuento)
                $realData[$descuento['nombre_descuento']] = '';

            $actualDescuentos = $this->modPagoDescuento->mdVerDePago($data['id_pago']);
            foreach ($actualDescuentos as $actual)
                $realData[$actual['nombre_descuento']] = $actual['cantidad_pago_descuento'];

            $actualBonificaciones = $this->modPagoBonificacion->mdVerDePago($data['id_pago']);
            foreach ($actualBonificaciones as $actual)
                $realData[$actual['nombre_bonificacion']] = $actual['cantidad_pago_bonificacion'];

            array_push($reporte, $realData);
        }
        return $reporte;
    }

}
