<?php
namespace App\Services\OpenAI\AIFile;

use App\Models\AIFile;
use OpenAI;

class AIFilesDownloader
{
    public function getAllFiles(AIFileService $aIFileService)
    {
        $yourApiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($yourApiKey);
        $newAIFile = new AIFile();

        $openAIFiles = $aIFileService->listAllFiles($client);
    
            foreach ($openAIFiles->data as $file) {
                if ($newAIFile::where('openai_id',$file->id)->count() > 0) {
                    
                    $newAIFile::where('openai_id',$file->id)->update([ 
                        'openai_id' => $file->id,
                        'user_id'   => 1,
                        'data'      => json_encode(['test for nu2']),
                        'tokens'    => 0,
                        'validering' => 0,
                        'traning'   => 1
                        ]);
                }
                else {
                    
                    #TODO sæt en klasse på som gør det her
                    $newAIFile->fill([ 
                    'openai_id' => $file->id,
                    'user_id'   => 1,
                    'data'      => json_encode(['test for nu']),
                    'tokens'    => 0,
                    'validering' => 0,
                    'traning'   => 1
                    ]);

                    $newAIFile->save();
                }
            }
                
                return $openAIFiles;
            }
    }
