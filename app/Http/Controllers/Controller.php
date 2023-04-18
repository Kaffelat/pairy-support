<?php

namespace App\Http\Controllers;

use App\Models\AIFile;
use App\Services\OpenAI\AIFile\AIFileService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;
use OpenAI;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function testGetAllFiles(AIFileService $aiFile)
    {
        $yourApiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($yourApiKey);

        $dbFile = AIFile::All();
 
        $openAIData = $aiFile->listAllFiles($client);

        foreach ($dbFile as $dbFile) {
            foreach ($openAIData->data as $file) {
                if ($dbFile->id != $file->id) {
                    $file = new AIFile($file);
                    $file->save();
                }
            }
        }
        dd($openAIData);

        return $openAIData;
    }

}
