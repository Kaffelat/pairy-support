<?php
namespace App\Services\OpenAI\AIFile;

use App\Models\AIFile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use OpenAI;

class AIFilesDownloader
{   
    protected $aiFileService;

    public function __construct(AIFileService $aiFileService)
    {
        $this->aiFileService = $aiFileService;
    }
    
    public function getAllFiles(): Collection
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);
        
        $AIFile = new AIFile;
        $downloadAIFile = new DownloadAIFiles;

        $openAIFiles = $this->aiFileService->listAllFiles($client);
    
            foreach ($openAIFiles->data as $file) {
                if ($AIFile::where('openai_id',$file->id)->count() > 0) {
                    
                    $downloadAIFile->updateAFileInDB($file, $AIFile);
                    
                }
                else {

                    $aiFile = new AIFile;
                    $aiFile->fill($downloadAIFile->getFileAttributes($file));
                    $aiFile->save();
                }
            }
            return AIFile::all();
        }

    public function getAFile(): object
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);

        return $this->aiFileService->getAFile($client, 'file-RfkFMyYoI0kcTcSynRFAfbmM');
    }

    public function getInfoAboutAFile(): object
    {
        $client = OpenAI::client(Auth::user()->openai_api_key);

        return $this->aiFileService->getInfoAboutAFile($client, 'file-RfkFMyYoI0kcTcSynRFAfbmM');
    }
    }
