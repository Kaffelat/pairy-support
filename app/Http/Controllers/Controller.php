<?php

namespace App\Http\Controllers;

use App\Models\AIFile;
use App\Services\OpenAI\AIFile\AIFileService;
use App\Services\OpenAI\AIFile\DownloadAIFIles;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;
use OpenAI;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    #Dette er bare til test af kode. skal ikke bruges i virkeligheden
    public function testGetAllFiles(AIFileService $aiFile)
    {
        $yourApiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($yourApiKey);

        $dbFile = AIFile::All();
 
        $openAIData = $aiFile->listAllFiles($client);
        
        
        if (empty($dbFile[0]) == false) {

            foreach ($dbFile as $dbFile) {
                foreach ($openAIData->data as $file) {
                    if ($dbFile->id != $file->id) {
                        
                        $newfile = new AIFile();
                        
                        #TODO sæt en klasse på som gør det her
                        $newfile->fill([ 
                        'openai_id' => $file->id,
                        'user_id'   => 1,
                        'data'      => json_encode(['test for nu']),
                        'tokens'    => 0,
                        'validering' => 0,
                        'traning'   => 1
                        ]);

                        $newfile->save();
                    }
                }
            }
        }
        else {
            foreach ($openAIData->data as $file) {
                
                $newfile = new AIFile();
                        
                #TODO sæt en klasse på som gør det her
                $newfile->fill([ 
                'openai_id' => $file->id,
                'user_id'   => 1,
                'data'      => ['test for nu'],
                'tokens'    => 0,
                'validering' => 0,
                'traning'   => 1
                ]);

                $newfile->save();
                }
            }

        return $openAIData;

    }
}
