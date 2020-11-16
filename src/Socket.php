<?php 
namespace itoeste\socket;
use Exception;
Class Socket {
    private $route = "157.245.219.22";
    private $token = null;
    function __construct(){

        if(!env("APIKEY_ITOESTESOCKET")){
            throw new Exception("Falta la variable APIKEY_ITOESTESOCKET en el archivo env",1);
        }

        if( empty(env("APIKEY_ITOESTESOCKET"))) {
            throw new Exception("La variable APIKEY_ITOESTESOCKET esta vacia",2);
        }

        $this->token = env("APIKEY_ITOESTESOCKET");
    }

    public function Notification($data)
    {
        $ruta = "http://".$this->route."/notification";
        $formJson = json_encode($data);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $ruta,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $formJson,
            CURLOPT_HTTPHEADER => array(
            "accept: application/json",
            "api-key: ".$this->token,
            "content-type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if($err){
            throw new Exception("Error de curl",3);
        }

        $responseJson2 = json_decode($response);
        return true;
    }

}