<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// list Foods
$app->get('/comment', function(Request $request,Response $response,$args){
    $conn   = $GLOBALS['dbconn'];
    $sql    = 'SELECT * FROM `comment`' ;
    $result = $conn->query($sql);
    $data   = array();
    while($row = $result->fetch_assoc()){
        array_push($data,$row);
    }
    $json = json_encode($data);
    $response->getBody()->write($json);
    return $response->withHeader('Content-Type','application/json');
});

// list Foods

$app->get('/comment/{key}', function(Request $request,Response $response,$args){
    $conn   = $GLOBALS['dbconn'];
    $aid   = $args['key'];
    $sql    = 'SELECT * FROM `comment` WHERE aid = ?' ;
    $stmt   =$conn->prepare($sql);
    $stmt->bind_param("i",$aid);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = array();
    while($row = $result->fetch_assoc())//fetch_assoc ดึงข้อมูลออกมาเก็บไส่ row
    {
        array_push($data,$row);//เอาข้อมูลจาก row เก็บไว้ใน Array Data
    }
    $json = json_encode($data);
    $response->getBody()->write($json);
    return $response->withHeader('Content-Type','application/json');
});

