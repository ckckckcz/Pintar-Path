<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CodeController extends Controller
{
    public function runPythonCode(Request $request)
    {
        $code = $request->input('code');
        $clientId = 'bd8afa49fb8c0456eec4912ed093c121';  // Ganti dengan Client ID Anda
        $clientSecret = '95c897580a48044d7829b45ffeb21a79d742d5b019e9bafc7bd804d4f0c3a611';  // Ganti dengan Client Secret Anda
    
        // Tentukan output yang diharapkan
        $expectedOutput = "Aku Cinta SkillQuest";
        
        $url = 'https://api.jdoodle.com/v1/execute';
    
        try {
            $response = Http::post($url, [
                'clientId' => $clientId,
                'clientSecret' => $clientSecret,
                'script' => $code,
                'language' => 'python3',
                'versionIndex' => '3',
            ]);
    
            $data = $response->json();
            $output = trim($data['output'] ?? ''); // Menghapus spasi ekstra dan baris baru
    
            // Debugging output
            \Log::info('Raw Output: ' . $data['output']);
            \Log::info('Trimmed Output: ' . $output);
    
            // Memeriksa apakah output sesuai dengan output yang diharapkan
            $isCorrect = (strcasecmp($output, $expectedOutput) === 0);
    
            return response()->json([
                'rawOutput' => $output,
                'outputMessage' => $isCorrect 
                    ? 'Output Sesuai!' 
                    : 'Output Tidak Sesuai',
                'isCorrect' => $isCorrect,
                'error' => $data['error'] ?? ''
            ]);
    
        } catch (\Exception $e) {
            return response()->json(['output' => 'Terjadi kesalahan internal server'], 500);
        }
    }    
}

