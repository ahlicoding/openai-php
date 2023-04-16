<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Http;

class OpenAI
{
    protected $baseUrl = 'https://api.openai.com/v1/chat/';

    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('OPENAI_API_KEY');
    }

    public function sendPrompt2($prompt)
    {
        // $messages = {
        //     "model": "gpt-3.5-turbo",
        //     "messages": [{"role": "user", "content": "Hello!"}]
        //   } ;
          
        


        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $this->apiKey",
        ])->post($this->baseUrl.'completions', [
           "model" => "gpt-3.5-turbo",
        //    "messages" => [{ ["role"=>"user"], ["content"=> "Hello!"]}]
        ]);

        return $response->json();
    }

    function getModel($idmodel){

        switch ($idmodel) {
            case 1 : return "gpt-3.5-turbo" ; break;
            case 2 : return "gpt-4" ; break;
            case 3 : return "GPT-2" ; break;
            case 4 : return "GPT" ; break;
            case 5 : return "GPT-Neo" ; break;
            case 6 : return "Codex" ; break;
            case 7 : return "DALL-E" ; break;
            case 8 : return "CLIP" ; break;
        }

        // <option value="1">gpt-3.5-turbo</option>
        // <option value="2">text-davinci-001</option>
        // <option value="3">text-davinci-002</option>
        // <option value="4">text-davinci-003</option>
        // <option value="5">davinci</option>
        // <option value="6">curie</option>
        // <option value="7">babbage</option>
        // <option value="8">ada</option>

    }


    public function sendPrompt($prompt){
        $curl = curl_init();

        // $model = 'gpt-3.5-turbo' ;
        $model = $this->getModel($prompt['model']); 

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
        "model": "'.$model.'",
        "max_tokens": '.$prompt['max_tokens'].',
        "messages": [{"role": "user", "content": "'.$prompt['input'].'"}]
        }
        ',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer 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',
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response ;
    }



}
