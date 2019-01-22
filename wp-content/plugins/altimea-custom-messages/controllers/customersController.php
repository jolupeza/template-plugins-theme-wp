<?php

use Endroid\SimpleExcel\SimpleExcel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\IOFactory;

class customersController extends Controller
{
    private $sizeFile;
    private $excel;
    private $headers;

    public function __construct()
    {
        parent::__construct();
        $this->sizeFile = 2097152;
        $this->headers = array();
    }

    public function index()
    {

    }

    public function generateExcel()
    {
        $this->excel = new SimpleExcel();
//        $objPHPExcel = new PHPExcel();

        $objPHPExcel = new Spreadsheet();

        $filename = 'clientes.xlsx';

        $title = 'Relación de Clientes';

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('Listado de Clientes');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(45);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);

        $this->generateHeaderExcel($objPHPExcel);
        $this->generateCellsExcel($objPHPExcel);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //mime type XLSX
//        header('Content-Type: application/vnd.ms-excel'); //mime type XLS
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx');
        $objWriter->save('php://output');

//        $this->excel->loadFromArray(array('Postulantes' => $data));
//        $this->excel->saveToOutput($filename, array('Postulantes'));
    }

    private function generateHeaderExcel(Spreadsheet $excel)
    {
        $headers = $this->setHeaders();

        if (count($headers)) {
            foreach ($headers as $key => $value) {
                $excel->getActiveSheet()->setCellValue($key, $value);
                $excel->getActiveSheet()->getStyle($key)->getFont()->setSize(11);
                $excel->getActiveSheet()->getStyle($key)->getFont()->setBold(true);
                $excel->getActiveSheet()->getStyle($key)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
        }
    }

    private function setHeaders()
    {
        $this->headers = array(
            'A3' => 'Nombre',
            'B3' => 'Correo electrónico',
            'C3' => 'Teléfono',
            'D3' => 'Tipo Doc',
            'E3' => 'Num Doc',
            'F3' => 'Modelo',
            'G3' => 'Fecha',
        );

        return $this->headers;
    }

    private function generateCellsExcel(Spreadsheet $excel)
    {
        global $wpdb;

        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'customers',
        );

        $i = 4;
        $the_query = new WP_Query($args);

        if ($the_query->have_posts()) {
            while ($the_query->have_posts()) {
                $the_query->the_post();

                $id = get_the_ID();
                $values = get_post_custom($id);

                $name = !empty($values['mb_name']) ? esc_attr($values['mb_name'][0]) : '';
                $apePat = !empty($values['mb_apePat']) ? esc_attr($values['mb_apePat'][0]) : '';
                $apeMat = !empty($values['mb_apeMat']) ? esc_attr($values['mb_apeMat'][0]) : '';
                $email = !empty($values['mb_email']) ? esc_attr($values['mb_email'][0]) : '';
                $phone = !empty($values['mb_phone']) ? esc_attr($values['mb_phone'][0]) : '';
                $typeDoc = !empty($values['mb_typeDoc']) ? esc_attr($values['mb_typeDoc'][0]) : '';
                $numDoc = !empty($values['mb_numDoc']) ? esc_attr($values['mb_numDoc'][0]) : '';
                $car = !empty($values['mb_car']) ? esc_attr($values['mb_car'][0]) : null;
                $date = get_the_time('d-m-Y');

                $theCar = null;
                if (!is_null($car) && $car > 0) {
                    $theCar = get_post($car);
                }

                $excel->getActiveSheet()->setCellValue('A'.$i, "{$name} {$apePat} {$apeMat}");
                $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('B'.$i, $email);
                $excel->getActiveSheet()->getStyle('B'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('C'.$i, $phone);
                $excel->getActiveSheet()->getStyle('C'.$i)->getFont()->setSize(10);
                $excel->getActiveSheet()->getStyle('C'.$i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $excel->getActiveSheet()->setCellValue('D'.$i, strtoupper($typeDoc));
                $excel->getActiveSheet()->getStyle('D'.$i)->getFont()->setSize(10);
                $excel->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $excel->getActiveSheet()->setCellValue('E'.$i, $numDoc);
                $excel->getActiveSheet()->getStyle('E'.$i)->getFont()->setSize(10);
                $excel->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $excel->getActiveSheet()->setCellValue('F'.$i, !is_null($theCar) ? $theCar->post_title : '');
                $excel->getActiveSheet()->getStyle('F'.$i)->getFont()->setSize(10);

                $excel->getActiveSheet()->setCellValue('G'.$i, $date);
                $excel->getActiveSheet()->getStyle('G'.$i)->getFont()->setSize(10);
                $excel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                ++$i;
            }
        }
        wp_reset_postdata();
    }
}