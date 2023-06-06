<?php
namespace App\Services\OpenAI\AIModelResultFile;

use OpenAI\Client;

class AIModelResultFileService
{
    public function downloadResultFile(Client $client, String $fileId): array
    {
        $response = $client->files()->download($fileId);

        $lines = explode("\n", $response);
        $data = [];
        
        for ($i = 1; $i < count($lines)-1; $i++) {
            $values = explode(',', $lines[$i]);
            array_push($data, $values);
        }
        
        return $data;
    }
}