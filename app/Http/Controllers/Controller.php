<?php

namespace App\Http\Controllers;

use App\Services\OpenAI\AIModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenAI;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function test()
    {
        $yourApiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($yourApiKey);

        $response = $client->files()->retrieve('file-eFIFEp23oMQuDJ3d6kR58J9i');
        
        $response->id; // 'file-XjGxS3KTG0uNmNOK362iJua3'
        $response->object; // 'file'
        $response->bytes; // 140
        $response->createdAt; // 1613779657
        $response->filename; // 'mydata.jsonl'
        $response->purpose; // 'fine-tune'
        $response->status; // 'succeeded'

        return $response->toArray(); // ['id' => 'file-XjGxS3KTG0uNmNOK362iJua3', ...]
    }
}
