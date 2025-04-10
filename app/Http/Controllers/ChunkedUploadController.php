<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChunkedUploadController extends Controller
{
    public function uploadChunk(Request $request)
    {
        // Mendapatkan informasi chunk dari request
        $chunk = $request->input('dzchunkindex') ?? 0;
        $totalChunks = $request->input('dztotalchunkcount') ?? 1;
        $uuid = $request->input('dzuuid');
        $documentType = $request->input('document_type', 'default');
        
        // Mendapatkan chunk file
        $file = $request->file('file');
        
        if (!$file) {
            return response()->json(['error' => 'No file uploaded'], 400);
        }
        
        // Buat direktori untuk menyimpan chunk sementara
        $tempDirectory = storage_path('app/chunks/' . $uuid);
        if (!file_exists($tempDirectory)) {
            mkdir($tempDirectory, 0777, true);
        }
        
        // Simpan chunk ke direktori sementara
        $chunkFile = $file->move($tempDirectory, $chunk);
        
        // Jika ini adalah chunk terakhir, gabungkan semua chunk menjadi satu file
        if ($chunk == $totalChunks - 1) {
            // Tentukan nama file akhir (sesuaikan dengan kebutuhan)
            $originalName = $request->input('dzfilename');
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            $finalFileName = $documentType . '_' . Str::random(10) . '_' . time() . '.' . $extension;
            $finalPath = 'uploads/' . $finalFileName;
            
            // Kombinasikan semua chunk
            $finalFilePath = storage_path('app/' . $finalPath);
            
            // Pastikan direktori uploads ada
            $uploadsDir = storage_path('app/uploads');
            if (!file_exists($uploadsDir)) {
                mkdir($uploadsDir, 0777, true);
            }
            
            $targetFile = fopen($finalFilePath, 'wb');
            
            for ($i = 0; $i < $totalChunks; $i++) {
                $chunkFilePath = $tempDirectory . '/' . $i;
                if (file_exists($chunkFilePath)) {
                    $chunk = fopen($chunkFilePath, 'rb');
                    stream_copy_to_stream($chunk, $targetFile);
                    fclose($chunk);
                }
            }
            
            fclose($targetFile);
            
            // Hapus direktori chunk sementara
            $this->deleteDirectory($tempDirectory);
            
            // Berikan respons sukses dengan path file akhir
            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully',
                'path' => $finalPath
            ]);
        }
        
        // Jika bukan chunk terakhir, berikan respons bahwa chunk berhasil diupload
        return response()->json([
            'success' => true,
            'message' => 'Chunk uploaded successfully',
            'chunk' => $chunk,
            'total' => $totalChunks
        ]);
    }
    
    /**
     * Delete a directory recursively
     *
     * @param string $dir Directory path
     * @return bool
     */
    private function deleteDirectory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }
        
        if (!is_dir($dir)) {
            return unlink($dir);
        }
        
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            
            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }
        
        return rmdir($dir);
    }
}