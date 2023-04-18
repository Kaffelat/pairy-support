<?php

namespace App\Http\Controllers;

use App\Models\AIModel;
use App\Models\AIModelData as AIData;
use App\Services\OpenAI\AIModelData;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;
use OpenAI;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function testGetAllFiles(AIModelData $aiData)
    {
        $yourApiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($yourApiKey);

        $dbData = AIData::All();

        $openAIData = $aiData->listAllFiles($client);

        foreach ($dbData as $dbItem) {
            foreach ($openAIData->data as $file) {
                if ($dbItem->id != $file->id) {
                    $file = new AIData($file);
                    $file->save();
                }
            }
        }

        dd($dbData[0]->id);

        return $openAIData;
    }

}
