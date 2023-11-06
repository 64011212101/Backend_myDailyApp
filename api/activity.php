<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// list activity
$app->get('/activity', function(Request $request,Response $response,$args){
    $conn   = $GLOBALS['dbconn'];
    $sql    = 'SELECT * FROM `activity` ORDER BY date DESC' ;
    $result = $conn->query($sql);
    $data   = array();
    while($row = $result->fetch_assoc()){
        array_push($data,$row);
    }
    $json = json_encode($data);
    $response->getBody()->write($json);
    return $response->withHeader('Content-Type','application/json');
});
// insert activity
$app->post('/activity/insert', function(Request $request, Response $response, $args){
    $conn   =$GLOBALS['dbconn'];
    $body   = $request->getBody();
    $bodyArr    = json_decode($body,true);

    $sql    = 'INSERT INTO `activity`(`uid`, `tid`, `story`, `shortstory`, `date`) VALUES (?,?,?,?,CURRENT_TIMESTAMP())';
    $stmt   = $conn->prepare($sql);
    $stmt->bind_param("iiss",$bodyArr['uid'],$bodyArr['tid'],$bodyArr['story'],$bodyArr['shortstory']);
    $stmt->execute();

    $value = array("status"=>'0',"result"=>'success');
    $json = json_encode($value);
    $response->getBody()->write($json);
    return $response->withHeader('Content-Type','application/json');
});

// list activity By uid
$app->get('/activity/user/{key}', function(Request $request,Response $response,$args){
    $conn   = $GLOBALS['dbconn'];
    $uid   = $args['key'];
    $sql    = 'SELECT * FROM `activity` WHERE uid = ? ORDER BY date DESC' ;
    $stmt   =$conn->prepare($sql);
    $stmt->bind_param("i",$uid);
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
$app->get('/activity/getbyid/{key}', function(Request $request,Response $response,$args){
    $conn   = $GLOBALS['dbconn'];
    $aid   = $args['key'];
    $sql    = 'SELECT * FROM `activity` WHERE aid = ? ORDER BY date DESC' ;
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

// list activity By tid
$app->get('/activity/type/{key}', function(Request $request,Response $response,$args){
    $conn   = $GLOBALS['dbconn'];
    $uid   = $args['key'];
    $sql    = 'SELECT * FROM `activity` WHERE tid = ? ORDER BY date DESC' ;
    $stmt   =$conn->prepare($sql);
    $stmt->bind_param("i",$uid);
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
// list activity today
$app->get('/activity/today', function(Request $request,Response $response,$args){
    $conn   = $GLOBALS['dbconn'];
    $sql    = 'SELECT * FROM `activity` WHERE date_format(date, \'%Y-%m-%d\') = CURRENT_DATE()' ;
    $result = $conn->query($sql);
    $data   = array();
    while($row = $result->fetch_assoc()){
        array_push($data,$row);
    }
    $json = json_encode($data);
    $response->getBody()->write($json);
    return $response->withHeader('Content-Type','application/json');
});
// update status order
$app->post('/activity/update', function (Request $request, Response $response, $args) {
    $conn   = $GLOBALS['dbconn'];
    $body   = $request->getBody();
    $bodyArr    = json_decode($body,true);

    $sql = 'UPDATE `activity` SET `story`=?,`shortstory`=? WHERE aid = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi',$bodyArr['story'],$bodyArr['shortstory'] ,$bodyArr['aid']);
    $stmt->execute();
    $affected = $stmt->affected_rows;
    if ($affected > 0) {
        $data = ["affected_rows" => $affected];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
});
//delete food
$app->delete('/activity/delete/{aid}', function(Request $request,Response $response,$args){
    $conn   = $GLOBALS['dbconn'];

    $aid   = $args['aid'];
    $sql    = 'DELETE FROM `image` WHERE aid = ?' ;
    $stmt   =$conn->prepare($sql);
    $stmt->bind_param("i",$aid);
    $stmt->execute();

    $aid   = $args['aid'];
    $sql    = 'DELETE FROM `comment` WHERE aid = ?' ;
    $stmt   =$conn->prepare($sql);
    $stmt->bind_param("i",$aid);
    $stmt->execute();

    $aid   = $args['aid'];
    $sql    = 'DELETE FROM `activity` WHERE aid = ?' ;
    $stmt   =$conn->prepare($sql);
    $stmt->bind_param("i",$aid);
    $stmt->execute();

    $value = array("status"=>'success');
    $json = json_encode($value);
    $response->getBody()->write($json);
    return $response->withHeader('Content-Type','application/json');
});
