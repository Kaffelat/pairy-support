<?php
namespace App\Services\OpenAI\AIFile;

use App\Models\AIFile;
use OpenAI;

class AIFilesDownloader
{   
    protected $aiFileService;

    public function __construct(AIFileService $aiFileService)
    {
        $this->aiFileService = $aiFileService;
    }
    
    public function getAllFiles()
    {
        $yourApiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($yourApiKey);
        
        $AIFile = new AIFile;
        $downloadAIFile = new DownloadAIFiles;

        $openAIFiles = $this->aiFileService->listAllFiles($client);
    
            foreach ($openAIFiles->data as $file) {
                if ($AIFile::where('openai_id',$file->id)->count() > 0) {
                    
                    $downloadAIFile->updateAFileInDB($file, $AIFile);
                    
                }
                else {
                    
                    $AIFile = new AIFile;
                    $AIFile->fill($downloadAIFile->getFileAttributes($file));
                    $AIFile->save();
                }
            }
                return $openAIFiles;
        }
    }
