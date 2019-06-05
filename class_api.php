<?php

class Api{

    protected $requestMethod;
    protected $allowedMethods;
    protected $requestParams;

    protected $data;

    protected $getType;
    protected $getID;
    protected $getScope;





    public function __construct(){
        $this->allowedMethods = array("GET", "POST", "PUT", "DELETE");

    }


    public function setAllowedMethods($array){
        $this->allowedMethods = $array;
    }

    public function printAllowedMethods(){
        foreach($this->allowedMethods as $val){
            $res = $val.",";
        }
        $res = mb_substr($res, 0, -1);
        return $res;
    }


    public function setRequestMethod($method){
        if(in_array($method, $this->allowedMethods)){
            $this->requestMethod = mb_strtoupper ( $method );
        }else{
            exit("Sorry. The request method you tried to use is not allowed.");
        }
    }


    public function requireSSL(){
        if ( (! empty($this->requestParams['REQUEST_SCHEME']) && $this->requestParams['REQUEST_SCHEME'] == 'https') ||
            (! empty($this->requestParams['HTTPS']) && $this->requestParams['HTTPS'] == 'on') ||
            (! empty($this->requestParams['SERVER_PORT']) && $this->requestParams['SERVER_PORT'] == '443') ) {
            return true;
        } else {
            exit("Sorry. The request must be made using https");
        }

    }


    public function loadRequest($server){
        $this->requestParams = $server;
    }


    public function prepareData(){

        if($this->requestMethod == "GET") {

            if ($this->getType == "item") {
                $data = array(
                    1 => array(
                        "name" => "Buty do koszykówki",
                        "category" => "Obuwie sportowe",
                        "availableSize" => array(
                            39 => 43,
                            40 => 27,
                            41 => 15,
                            42 => 37,
                            44 => 59,
                            52 => 95,
                        ),
                        "prize" => 39999
                    ),
                    2 => array(
                        "name" => "Buty do piłki nożnej",
                        "category" => "Obuwie sportowe",
                        "availableSize" => array(
                            39 => 5,
                            40 => 11,
                            41 => 7,
                            42 => 7,
                            44 => 43,
                            45 => 4,
                        ),
                        "prize" => 29999
                    )
                );
            }

            if (is_numeric($this->getID) AND $this->getID > 0) {
                $res[$this->getID] = $data[$this->getID];
            } else {
                $res = $data;
            }

            if (count($this->getScope) > 0) {
                foreach ($res as $key => $val) {
                    foreach ($this->getScope as $scope) {
                        $result[$key][$scope] = $val[$scope];
                    }
                }
                $dataToUpdate = $result;
            } else {
                $dataToUpdate = $res;
            }

            if (count($dataToUpdate) == 1) {
                $this->data = $dataToUpdate[$this->getID];
            } else if (count($dataToUpdate) == 0) {
                exit("Item not found");
            } else {
                $this->data = $dataToUpdate;
            }


        }


    }



    public function response(){

        echo json_encode($this->data);


    }



    public function loadParams($arg){
        if(array_key_exists("scope", $arg)){
            $this->getScope = explode(",", $arg["scope"]);
        }
        if(array_key_exists("id", $arg)){
            $this->getID = $arg["id"];
        }
        if(array_key_exists("type", $arg)){
            $this->getType = $arg["type"];
        }
    }




}
