<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TMapScreenshot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class MapScreenshotController extends Controller
{
    /**
     * Capturar screenshot del mapa
     */
    public function capture(Request $request)
    {
        try {
            // Manejar captura manual (solo registro)
            if ($request->has('manual_capture')) {
                $now = Carbon::now();
                
                $screenshot = TMapScreenshot::create([
                    'filename' => 'captura_manual_' . $now->format('Y-m-d_H-i-s') . '.txt',
                    'filepath' => 'img/mapa/captura_manual_' . $now->format('Y-m-d_H-i-s') . '.txt',
                    'capture_date' => $now->toDateString(),
                    'year' => $now->year,
                    'month' => $now->month,
                    'month_name' => TMapScreenshot::getSpanishMonthName($now->month),
                    'is_automatic' => false,
                    'description' => 'Captura manual del usuario usando Print Screen',
                    'metadata' => [
                        'type' => 'manual',
                        'instructions' => 'Usuario debe usar Print Screen para capturar pantalla',
                        'timestamp' => $now->toDateTimeString()
                    ]
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Captura manual registrada',
                    'filename' => $screenshot->filename,
                    'id' => $screenshot->id
                ]);
            }
            
            // Manejar captura automática (archivo)
            if (!$request->hasFile('map_screenshot')) {
                return response()->json(['success' => false, 'message' => 'No se recibió ninguna imagen']);
            }
            
            $file = $request->file('map_screenshot');
            $now = Carbon::now();
            
            // Usar directorio public/img/mapa directamente
            $publicMapaDir = public_path('img/mapa');
            if (!file_exists($publicMapaDir)) {
                mkdir($publicMapaDir, 0755, true);
            }
            
            // Generar nombre único para el archivo
            $filename = 'captura_mapa_' . $now->format('Y-m-d_H-i-s') . '_' . uniqid() . '.png';
            $filepath = 'img/mapa/' . $filename;
            
            // Guardar archivo directamente en public/img/mapa
            $file->move($publicMapaDir, $filename);
            
            // Determinar si es captura automática basado en el parámetro
            $isAutomatic = $request->has('is_automatic') && $request->get('is_automatic') === 'true';
            $description = $isAutomatic ? 'Captura automática de test' : 'Captura desde el dashboard';
            
            // Guardar registro en base de datos
            $screenshot = TMapScreenshot::create([
                'filename' => $filename,
                'filepath' => $filepath,
                'capture_date' => $now->toDateString(),
                'year' => $now->year,
                'month' => $now->month,
                'month_name' => TMapScreenshot::getSpanishMonthName($now->month),
                'is_automatic' => $isAutomatic,
                'description' => $description,
                'metadata' => [
                    'user_agent' => $request->userAgent(),
                    'ip' => $request->ip(),
                    'timestamp' => $now->toDateTimeString(),
                    'type' => $isAutomatic ? 'automatic_test' : 'manual'
                ]
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Mapa capturado exitosamente',
                'filename' => $filename,
                'id' => $screenshot->id
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al capturar el mapa: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Mostrar historial de capturas
     */
    public function history()
    {
        $screenshots = TMapScreenshot::orderBy('capture_date', 'desc')
                                  ->paginate(20);
        
        return view('map.history', compact('screenshots'));
    }
    
    /**
     * Generar Excel con imagen del mapa y datos
     */
    public function exportWithMap(Request $request)
    {
        try {
            $screenshotId = $request->get('screenshot_id');
            $screenshot = TMapScreenshot::findOrFail($screenshotId);
            
            // Crear nuevo spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Configurar título
            $sheet->setCellValue('A1', 'REPORTE DE CALIDAD DEL AGUA - MI COLE CON AGUA');
            $sheet->mergeCells('A1:H1');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            
            // Información del reporte
            $sheet->setCellValue('A3', 'Fecha de generación:');
            $sheet->setCellValue('B3', Carbon::now()->format('d/m/Y H:i'));
            $sheet->setCellValue('A4', 'Periodo:');
            $sheet->setCellValue('B4', $screenshot->month_name . ' ' . $screenshot->year);
            $sheet->setCellValue('A5', 'Mapa capturado:');
            $sheet->setCellValue('B5', $screenshot->capture_date->format('d/m/Y'));
            
            // Agregar imagen del mapa
            $imagePath = public_path($screenshot->filepath);
            if (file_exists($imagePath)) {
                $drawing = new Drawing();
                $drawing->setName('Mapa de Calor');
                $drawing->setDescription('Mapa de Calidad del Agua');
                $drawing->setPath($imagePath);
                $drawing->setHeight(400);
                $drawing->setCoordinates('A7');
                $drawing->setWorksheet($sheet);
                
                // Ajustar altura de filas para la imagen
                for ($row = 7; $row <= 25; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(20);
                }
            }
            
            // Obtener datos de instituciones (ejemplo)
            $startRow = 27;
            $sheet->setCellValue("A{$startRow}", 'DATOS DE INSTITUCIONES');
            $sheet->mergeCells("A{$startRow}:H{$startRow}");
            $sheet->getStyle("A{$startRow}")->getFont()->setBold(true)->setSize(14);
            
            $headerRow = $startRow + 2;
            $headers = ['UGEL', 'Institución', 'Provincia', 'Distrito', 'MCR S.1', 'MCR S.2', 'MCR S.3', 'MCR S.4'];
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . $headerRow, $header);
                $sheet->getStyle($col . $headerRow)->getFont()->setBold(true);
                $sheet->getStyle($col . $headerRow)->getFill()
                      ->setFillType(Fill::FILL_SOLID)
                      ->getStartColor()->setARGB('FFE0E0E0');
                $col++;
            }
            
            // Aquí puedes agregar los datos reales de las instituciones
            // Por ahora agrego datos de ejemplo
            $dataRow = $headerRow + 1;
            $sheet->setCellValue("A{$dataRow}", 'UGEL Ejemplo');
            $sheet->setCellValue("B{$dataRow}", 'IE Ejemplo');
            $sheet->setCellValue("C{$dataRow}", 'Andahuaylas');
            $sheet->setCellValue("D{$dataRow}", 'Ejemplo');
            $sheet->setCellValue("E{$dataRow}", '0.8');
            $sheet->setCellValue("F{$dataRow}", '0.7');
            $sheet->setCellValue("G{$dataRow}", '0.9');
            $sheet->setCellValue("H{$dataRow}", '0.6');
            
            // Autoajustar columnas
            foreach (range('A', 'H') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }
            
            // Generar archivo
            $writer = new Xlsx($spreadsheet);
            $filename = 'reporte_mapa_' . $screenshot->year . '_' . sprintf('%02d', $screenshot->month) . '_' . date('YmdHis') . '.xlsx';
            $tempPath = storage_path('app/temp/' . $filename);
            
            // Crear directorio temporal si no existe
            if (!file_exists(dirname($tempPath))) {
                mkdir(dirname($tempPath), 0755, true);
            }
            
            $writer->save($tempPath);
            
            return response()->download($tempPath)->deleteFileAfterSend(true);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al generar el Excel: ' . $e->getMessage());
        }
    }
    
    /**
     * Eliminar una captura de mapa
     */
    public function delete($id)
    {
        try {
            $screenshot = TMapScreenshot::findOrFail($id);
            
            // Eliminar archivo físico si existe
            $filePath = public_path($screenshot->filepath);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            // Eliminar registro de base de datos
            $screenshot->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Mapa eliminado exitosamente'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el mapa: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Captura automática del último día del mes (para ser llamada por cron)
     */
    public function automaticCapture()
    {
        // Para testing, comentamos la validación de último día
        // if (!TMapScreenshot::isLastDayOfMonth()) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Hoy no es el último día del mes'
        //     ]);
        // }
        
        try {
            $now = Carbon::now();
            
            // Verificar si ya existe una captura automática para este mes
            $existing = TMapScreenshot::where('year', $now->year)
                                   ->where('month', $now->month)
                                   ->where('is_automatic', true)
                                   ->first();
            
            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe una captura automática para este mes'
                ]);
            }
            
            // Solo devolver la señal para que el frontend haga la captura marcándola como automática
            return response()->json([
                'success' => true,
                'message' => 'Ejecutando test de captura automática',
                'action' => 'trigger_frontend_capture',
                'mark_as_automatic' => true
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en captura automática: ' . $e->getMessage()
            ]);
        }
    }
}