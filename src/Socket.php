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
            "Authorization: bearer ".$this->token,
            "content-type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);

        if($err){
            throw new Exception("Error de curl",3);
        }

        $responseJson2 = json_decode($response);
        if(!empty($info)){

            if($info['http_code'] == 200){
                
                return $responseJson2;
            }else{
                if($info['http_code'] == 500){
                    throw new Exception("Error 500 en servicio Notification",4);
                }else if($info['http_code'] == 401){
                    throw new Exception("Error de privilegios , es necesario el token de auth en: Notification",5);
                }else if($info['http_code'] == 404){
                    throw new Exception("Error 404 con el servicio Notification",4);
                }else if($info['http_code'] == 404){
                    throw new Exception("Error 404 con el servicio Notification",7);
                }else{
                    throw new Exception("Error desconocido con el servicio Notification",8);
                }
            }
            
        }else{
            throw new Exception("Error curl info vacio",9);
        }
        return false;
    }
}