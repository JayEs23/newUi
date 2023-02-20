<?php

class Route {

    // //public const $base_dir = __DIR__;
    // public const $doc_root = $_SERVER['DOCUMENT_ROOT'];


    private function simpleRoute($file, $route){

        
        //replacing first and last forward slashes
        //$_SERVER['REQUEST_URI'] will be empty if req uri is /

        if(!empty($_SERVER['REQUEST_URI'])){
            $route = preg_replace("/(^\/)|(\/$)/","",$route);
            $reqUri =  preg_replace("/(^\/)|(\/$)/","",$_SERVER['REQUEST_URI']);
        }else{
            $reqUri = "/";
        }

        if($reqUri == $route){
            // echo "<pre>";
            // print_r($_SERVER);
            // echo $_SERVER['DOCUMENT_ROOT'].'/',$_SERVER['REQUEST_URI']; die;
            $params = [];
            include($_SERVER['DOCUMENT_ROOT'].'/'.$file);
            exit();

        }

    }
    

    public function add($route, $file){

        //will store all the parameters value in this array
        $params = [];

        //will store all the parameters names in this array
        $paramKey = [];

        //finding if there is any {?} parameter in $route
        preg_match_all("/(?<={).+?(?=})/", $route, $paramMatches);

        //if the $route does not contain any param call simpleRoute();
        if(empty($paramMatches[0])){
            $this->simpleRoute($file,$route);
            return;
        }

        //setting parameters names
        foreach($paramMatches[0] as $key){
            $paramKey[] = $key;
        }

        //replacing first and last forward slashes
        //$_SERVER['REQUEST_URI'] will be empty if req uri is /

        if(!empty($_SERVER['REQUEST_URI'])){
            $route = preg_replace("/(^\/)|(\/$)/","",$route);
            $reqUri =  preg_replace("/(^\/)|(\/$)/","",$_SERVER['REQUEST_URI']);
        }else{
            $reqUri = "/";
        }

        //exploding route address
        $uri = explode("/", $route);
        //will store index number where {?} parameter is required in the $route 
        $indexNum = []; 

        //storing index number, where {?} parameter is required with the help of regex
        foreach($uri as $index => $param){
            if(preg_match("/{.*}/", $param)){
                $indexNum[] = $index;
            }
        }

        //exploding request uri string to array to get
        //the exact index number value of parameter from $_SERVER['REQUEST_URI']
        $reqUri = explode("/", $reqUri);

        //running for each loop to set the exact index number with reg expression
        //this will help in matching route
        foreach($indexNum as $key => $index){

            //in case if req uri with param index is empty then return
            //because url is not valid for this route
            if(empty($reqUri[$index])){
                return;
            }

            //setting params with params names
            $params[$paramKey[$key]] = $reqUri[$index];

            //this is to create a regex for comparing route address
            $reqUri[$index] = "{.*}";
        }

        //converting array to sting
        $reqUri = implode("/",$reqUri);

        //replace all / with \/ for reg expression
        //regex to match route is ready !
        $reqUri = str_replace("/", '\\/', $reqUri);

        //now matching route with regex
        if(preg_match("/$reqUri/", $route))
        {
            include($file);
            exit();

        }

        
    }
    public function notFound($file){
        include($file);
        exit();
}
}

//Route instance
// die('Error');
$route = new Route();

//route address and home.php file location
$route->add("/home", "../../home.php");
$route->add("/", "home.php");
$route->add("", "home.php");
$route->add("contact", "contact.php");
$route->add("", ".php");
$route->add("explore", "explore.php");
$route->add("process", "process.php");
$route->add("about", "about.php");
$route->add("/users/", "/users/index..php");
$route->add("/users/", "/users/index..php");
$route->add("/dashboard", "/users/index.php");
$route->add("", ".php");
$route->add("", ".php");
$route->add("", ".php");
$route->add("", ".php");
$route->add("", ".php");

$route->add('/products',"api/products/getProducts.php");

$route->add("/users/{id}","/api/users/getUsetDetails.php");


$route->notFound("404.php");


?>