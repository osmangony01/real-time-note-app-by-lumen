<?php


namespace App\Traits;

use GuzzleHttp\Client;

trait RequestService
{
    
    public function request($method, $requestUrl, $formParams = [], $headers = [])
    {
        $client = new Client([
            'base_uri' => $this->baseUri
        ]);

        if (isset($this->secret)) {
            $headers['Authorization'] = $this->secret;
        }

        $response = $client->request($method, $requestUrl,
            [
                'form_params' => $formParams,
                'headers' => $headers
            ]
        );

        return  $response->getBody()->getContents();

        // try {
        //     $response = $client->request($method, $requestUrl,
        //         [
        //             'form_params' => $formParams,
        //             'headers' => $headers
        //         ]
        //     );

        //     return $response->getBody()->getContents()->getMessage();
        // } catch (Exception $e) {
        //     // Handle the client-side error
        //     $statusCode = $e->getResponse()->getStatusCode();
        //     $errorMessage = $e->getMessage();

        //     $res = $this->extractJsonFromString($response->getBody()->getContents());

        //     return $res;
        // }
    }


    public function extractJsonFromString($errorString) {
        // Find the position of the JSON string within the error message
        $jsonStart = strpos($errorString, '{');
        $jsonEnd = strrpos($errorString, '}');
    
        if ($jsonStart !== false && $jsonEnd !== false) {
            // Extract the JSON string from the error message
            $jsonString = substr($errorString, $jsonStart, $jsonEnd - $jsonStart + 1);
    
            // // Decode the JSON string
            // $responseData = json_decode($jsonString, true);
    
            // if ($responseData !== null) {
            //     return $responseData;
            // } else {
            //     return ["error" => "Failed!"];
            // }
            if ($jsonString !== null) {
                return $jsonString;
            } else {
                return ["error" => "Failed!"];
            }

        } else {
            return ["error" => "JSON not found in error message"];
        }
    }
    
} 
