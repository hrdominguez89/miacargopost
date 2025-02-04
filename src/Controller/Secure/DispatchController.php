<?php

namespace App\Controller\Secure;

use App\Constants\ConstantsStatusBag;
use App\Constants\ConstantsStatusDispatch;
use App\Entity\Bags;
use App\Entity\Dispatch;
use App\Form\DispatchType;
use App\Repository\BagsRepository;
use App\Repository\DispatchRepository;
use App\Repository\OfficesRepository;
use App\Repository\PostalServiceRangeRepository;
use App\Repository\RoutesRepository;
use App\Repository\StatusBagRepository;
use App\Repository\StatusDispatchRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Style\Alignment as StyleAlignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dispatch')]
class DispatchController extends AbstractController

{
    #[Route('/new', name: 'app_secure_new_dispatch')]
    public function new(Request $request, EntityManagerInterface $em, OfficesRepository $officesRepository, RoutesRepository $routesRepository, StatusDispatchRepository $statusDispatchRepository, PostalServiceRangeRepository $postalServiceRangeRepository): Response
    {
        $data['active'] = 'dispatch';
        $data['title'] = 'Crear despacho';
        $data['dispatch'] = new Dispatch;
        $data['dispatches'] = [];
        $data['form'] =  $this->createForm(DispatchType::class, $data['dispatch']);

        $data['form']->handleRequest($request);
        if ($data['form']->isSubmitted() && $data['form']->isValid()) {
            $originOffice = $officesRepository->findOneBy(['id' => $request->get('dispatch')['originOffice']]);
            $destinationOffice = $officesRepository->findOneBy(['id' => $request->get('dispatch')['destinationOffice']]);
            $route =  $routesRepository->findOneBy(['id' => $request->get('dispatch')['routeId']]);
            $statusDispatch =  $statusDispatchRepository->findOneBy(['id' => ConstantsStatusDispatch::OPENED]);
            $postalServiceRange =  $postalServiceRangeRepository->findOneBy(['id' => $request->get('dispatch')['postalServiceRange']]);


            $data['dispatch']->setOriginOffice($originOffice)
                ->setDestinationOffice($destinationOffice)
                ->setRoute($route)
                ->setStatusDispatch($statusDispatch)
                ->setNumberDispatch($request->get('dispatch')['numberDispatch'])
                ->setItinerary($request->get('dispatch')['itinerary'])
                ->setPostalServiceRange($postalServiceRange)
                ->setDispatchCode($originOffice->getImpcCode() . $destinationOffice->getImpcCode() . 'A' . $postalServiceRange->getPrincipalCharacter() . $postalServiceRange->getSecondCharacterFrom() . substr(date('Y'), -1) . str_pad($request->get('dispatch')['numberDispatch'], 4, '0', STR_PAD_LEFT));
            $em->persist($data['dispatch']);
            $em->flush();
            $this->generateBarcodeImage($data['dispatch'], 'dispatches', $em);
            return $this->redirectToRoute('app_secure_dispatch_index', ['status_dispatch', 'OPENED']);
        }
        return $this->render('secure/dispatch/new_dispatch.html.twig', $data);
    }

    #[Route('/list/{dispatch_id}', name: 'app_secure_list_dispatch')]
    public function list(int $dispatch_id, DispatchRepository $dispatchRepository): Response
    {
        // Obtener los datos del despacho
        $dispatch = $dispatchRepository->findWithRelations($dispatch_id);
        if (!$dispatch) {
            throw $this->createNotFoundException('No se encontró el despacho.');
        }

        $bags = $dispatch->getBags();

        // Crear un nuevo archivo Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:A4")->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'D3D3D3'],
            ],
        ]);

        //<---- Encabezado "DESPACHO" --->
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'DESPACHO');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setBold(true);

        //<---- NRO DE DESPACHO --->
        $sheet->mergeCells('A2:G2');
        $sheet->setCellValue('A2', $dispatch->getDispatchCode());
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getFont()->setBold(true);

        //<---- CANTIDAD DE ENVASES ---> 
        $sheet->mergeCells('A3:G3');
        $sheet->setCellValue('A3', 'Cantidad de envases: ' . count($bags));
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3')->getFont()->setBold(true);

        //<---- PESO TOTAL ---> 
        $sheet->mergeCells('A4:G4');
        $sheet->setCellValue('A4', 'Peso total: ' . number_format($dispatch->getWeight(), 3));
        $sheet->getStyle('A4')->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A4')->getFont()->setBold(true);


        // Encabezado de ENVASES
        $sheet->getStyle("A5")->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF518137'],
            ],
            'font' => [
                'color' => ['argb' => 'FFFFFF'], // BLANCO
                'bold' => true, // Negrita
            ],
        ]);
        $sheet->mergeCells('A5:G5');
        $sheet->setCellValue('A5', 'ENVASES');
        $sheet->getStyle('A5')->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);


        // Encabezados de columnas para ENVASES
        $sheet->getStyle("A6:G6")->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF518137'],
            ],
            'font' => [
                'color' => ['argb' => 'FFFFFF'], // BLANCO
                'bold' => true, // Negrita
            ],
        ]);

        $sheet->setCellValue('A6', 'Envase Nro');
        $sheet->getStyle('A6')->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->mergeCells('B6:E6');
        $sheet->setCellValue('B6', 'Código');
        $sheet->getStyle('B6')->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('F6', 'Peso por envase');
        $sheet->getStyle('F6')->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);

        // Llenar datos de ENVASES
        $row = 7;
        $countRowBag = 0;
        foreach ($bags as $bag) {

            $isEvenRow = ($countRowBag % 2 === 0);
            $backgroundColor = $isEvenRow ? 'FFFFFF' : 'FFC6E0B3'; //BLANCO O VERDE AGUA

            $sheet->getStyle("A{$row}:G{$row}")->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => $backgroundColor],
                ]
            ]);

            $sheet->setCellValue("A{$row}", $bag->getNumberBag() . ($bag->isFinalBag() ? ' (F)' : ''));
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
            $sheet->mergeCells("B{$row}:E{$row}");
            $sheet->setCellValue("B{$row}", $bag->getBagCode());
            $sheet->getStyle("B{$row}")->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);

            $sheet->setCellValue("F{$row}", $bag->getWeight());
            $sheet->getStyle("F{$row}")->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
            $sheet->getStyle("F{$row}")->getNumberFormat()->setFormatCode('0.000');
            $row++;
            $countRowBag++;
        }

        // Encabezado de ITEMS

        $sheet->getStyle("A{$row}:G{$row}")->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF5CA4CD'],
            ],
        ]);

        $sheet->mergeCells("A{$row}:G{$row}");
        $sheet->setCellValue("A{$row}", 'ITEMS');
        $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A{$row}")->getFont()->setBold(true);

        // Encabezados de columnas para ITEMS
        $row++;

        $sheet->getStyle("A{$row}:G{$row}")->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF5CA4CD'],
            ],
        ]);
        $sheet->setCellValue("A{$row}", 'Cantidad');
        $sheet->getStyle("A6{$row}")->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->setCellValue("B{$row}", 'Producto');
        $sheet->getStyle("B6{$row}")->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->setCellValue("C{$row}", 'Peso');
        $sheet->getStyle("C6{$row}")->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->setCellValue("D{$row}", 'Código S10');
        $sheet->getStyle("D6{$row}")->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->setCellValue("E{$row}", 'Destinatario');
        $sheet->getStyle("E6{$row}")->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->setCellValue("F{$row}", 'Nro de envase');
        $sheet->getStyle("F6{$row}")->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->setCellValue("G{$row}", 'Código de envase');
        $sheet->getStyle("G6{$row}")->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A{$row}:G{$row}")->getFont()->setBold(true);

        // Llenar datos de ITEMS
        $row++;
        $countItem = 0;
        foreach ($bags as $bag) {
            foreach ($bag->getS10Codes() as $s10code) {
                foreach ($s10code->getItemDetails() as $item) {

                    // Alternar colores para cada fila
                    $isEvenRow = ($countItem % 2 === 0);
                    $backgroundColor = $isEvenRow ? 'FFFFFF' : 'FFBCD6ED'; //  Blanco o azul claro

                    // Aplicar el color de fondo
                    $sheet->getStyle("A{$row}:G{$row}")->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['argb' => $backgroundColor],
                        ],
                    ]);

                    $sheet->setCellValue("A{$row}", $item->getQuantity());
                    $sheet->setCellValue("B{$row}", $item->getDetailedContents());
                    $sheet->setCellValue("C{$row}", $item->getNetWeight());
                    $sheet->getStyle("C{$row}")->getNumberFormat()->setFormatCode('0.000');
                    $sheet->setCellValue("D{$row}", $s10code->getCode());
                    $sheet->setCellValue("E{$row}", $s10code->getToName());
                    $sheet->setCellValue("F{$row}", $s10code->getBag()->getNumberBag());
                    $sheet->setCellValue("G{$row}", $s10code->getBag()->getBagCode());
                    $row++;
                    $countItem++;
                }
            }
        }

        // Ajustar automáticamente el ancho de las columnas
        foreach (range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Aplicar bordes a todas las celdas utilizadas
        $lastRow = $row - 1;
        $sheet->getStyle("A1:G{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Generar la respuesta con el archivo Excel
        $response = new StreamedResponse(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        });

        // Configurar las cabeceras para la descarga
        $filename = "despacho_codigo_{$dispatch->getDispatchCode()}.xlsx";
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }


    #[Route('/bags/{dispatch_id}', name: 'app_secure_new_bags')]
    public function edit($dispatch_id, DispatchRepository $dispatchRepository, BagsRepository $bagsRepository, StatusBagRepository $statusBagRepository, Request $request, EntityManagerInterface $em, OfficesRepository $officesRepository, RoutesRepository $routesRepository, StatusDispatchRepository $statusDispatchRepository, PostalServiceRangeRepository $postalServiceRangeRepository): Response
    {
        $data['dispatch'] =  $dispatchRepository->find($dispatch_id);
        if ($data['dispatch']->getStatusDispatch()->getId() != ConstantsStatusDispatch::OPENED) {
            $data['bags'] = $data['dispatch']->getBags()->toArray(); // Convertimos la colección a un array

            // Ordenamos los bags por su ID
            usort($data['bags'], function ($a, $b) {
                return $a->getId() <=> $b->getId(); // Orden ascendente
            });

            $data['active'] = 'dispatch';
            $data['title'] = 'Crear envases';

            return $this->render('secure/dispatch/closed_bags.html.twig', $data);
        }


        $statusBag = $statusBagRepository->find(ConstantsStatusBag::OPENED);

        if ($request->request->has('cerrarEnvase')) {
            $data['bag'] = $bagsRepository->findOneBy(['dispatch' => $data['dispatch'], 'status' => $statusBag], ['id' => 'DESC']);
            if ($data['bag']->getS10Codes()[0]) {
                $data['bag']->setStatus($statusBagRepository->find(ConstantsStatusBag::CLOSED));
                $data['bag']->setBagCode($data['bag']->generateBagCode());
                $em->persist($data['bag']);
                $em->flush();
                $this->generateBarcodeImage($data['bag'], 'bags', $em);
                $this->addFlash('success', 'El envase se ha cerrado correctamente.');
                return $this->redirectToRoute('app_secure_new_bags', ['dispatch_id' => $dispatch_id]);
            } else {
                $this->addFlash('error', 'No se puede cerrar un envase vacio.');
                return $this->redirectToRoute('app_secure_new_bags', ['dispatch_id' => $dispatch_id]);
            }
        } elseif ($request->request->has('cerrarDespacho')) {
            $data['bag'] = $bagsRepository->findOneBy(['dispatch' => $data['dispatch'], 'status' => $statusBag], ['id' => 'DESC']);
            if ($data['bag']->getS10Codes()[0]) {
                $data['bag']->setStatus($statusBagRepository->find(ConstantsStatusBag::CLOSED));
            } else {
                $em->remove($data['bag']);
                $em->flush();
                $statusBagClosed = $statusBagRepository->find(ConstantsStatusBag::CLOSED);
                $data['bag'] = $bagsRepository->findOneBy(['dispatch' => $data['dispatch'], 'status' => $statusBagClosed], ['id' => 'DESC']);
            }
            $data['bag']->setIsFinalBag(true);
            $data['bag']->setBagCode($data['bag']->generateBagCode());
            $em->persist($data['bag']);
            $data['dispatch']->setStatusDispatch($statusDispatchRepository->find(ConstantsStatusDispatch::CLOSED));
            $em->persist($data['dispatch']);
            $em->flush();
            $this->generateBarcodeImage($data['bag'], 'bags', $em);
            $this->addFlash('success', ' se ha cerrado el despacho correctamente.');
            return $this->redirectToRoute('app_secure_new_bags', ['dispatch_id' => $dispatch_id]);
        }

        $data['bag'] = $bagsRepository->findOneBy(['dispatch' => $data['dispatch'], 'status' => $statusBag], ['id' => 'DESC']);
        if (!$data['bag']) {
            $data['bag'] = new Bags();
            $data['bag']->setNumberBag(count($data['dispatch']->getBags()) + 1)
                ->setWeight(0)
                ->setDispatch($data['dispatch'])
                ->setIsFinalBag(0)
                ->setIsCertified(0)
                ->setStatus($statusBag);

            $em->persist($data['bag']);
            $em->flush();
            $em->refresh($data['dispatch']);
        }

        $data['bags'] = $data['dispatch']->getBags()->toArray(); // Convertimos la colección a un array

        // Ordenamos los bags por su ID
        usort($data['bags'], function ($a, $b) {
            return $a->getId() <=> $b->getId(); // Orden ascendente
        });

        $data['active'] = 'dispatch';
        $data['title'] = 'Crear envases';

        return $this->render('secure/dispatch/new_bags.html.twig', $data);
    }

    #[Route('/{status_dispatch?}', name: 'app_secure_dispatch_index')]
    public function index($status_dispatch, DispatchRepository $dispatchRepository, StatusDispatchRepository $statusDispatchRepository): Response
    {
        if (!$status_dispatch) {
            $status_dispatch = "OPENED";
        }
        $data['status_dispatch'] = $status_dispatch;
        $data['active'] = 'dispatch';
        $statusDispatch = $statusDispatchRepository->findOneBy(['name' => $status_dispatch]);

        if (!$statusDispatch) {
            return $this->redirectToRoute('app_secure_dispatch_index', ['status_dispatch' => 'OPENED']);
        }

        $data['dispatches'] = $dispatchRepository->findBy(['statusDispatch' => $statusDispatch]);
        return $this->render('secure/dispatch/index.html.twig', $data);
    }

    private function generateBarcodeImage($ObjetoEntidad, $path, EntityManagerInterface $em): void
    {
        if ($path == 'bags') {
            $codigo = $ObjetoEntidad->generateBagCode();
        } else {
            $codigo = $ObjetoEntidad->getDispatchCode();
        }
        $rutaArchivo = $this->getParameter('kernel.project_dir') . '/public/barcodes/' . $path . '/' . $codigo . '.png';

        // Generar código de barras con picqer/php-barcode-generator (Code128)
        $generator = new BarcodeGeneratorPNG();
        $codigoBarras = $generator->getBarcode($codigo, $generator::TYPE_CODE_128);

        // Guardar la imagen en la carpeta /public/barcodes/s10/
        file_put_contents($rutaArchivo, $codigoBarras);

        // Actualizar la entidad ObjetoEntidad para guardar la ruta de la imagen
        $rutaRelativa = '/barcodes/' . $path . '/' . $codigo . '.png';
        $ObjetoEntidad->setBarcodeImage($rutaRelativa);

        // Persistir los cambios
        $em->persist($ObjetoEntidad);
        $em->flush();
    }
}
