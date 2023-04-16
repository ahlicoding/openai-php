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


    public function sendPrompt($prompt){
        $curl = curl_init();

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
        "model": '.$prompt['model'].',
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
