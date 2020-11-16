<?php 
namespace itoeste\socket;
use Exception;
Class Socket {
	$this->route = "192.168.1.8:3333";
	$this->token = null
	function __construct($options){
		if(!isset(env("APIKEY_ITOESTESOCKET"))){
			throw new Exception("Falta la variable APIKEY_ITOESTESOCKET en el archivo env",1);
		}

		if(empty(env("APIKEY_ITOESTESOCKET")){
			throw new Exception("La variable APIKEY_ITOESTESOCKET esta vacia",2);
		}

		$this->token = env("APIKEY_ITOESTESOCKET");
	}

	public function Notification($data)
	{
		$formJson = json_encode($data);
		$curl = curl_init();
		curl_setopt_array($curl2, array(
            CURLOPT_URL => $this->route."/temp",
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