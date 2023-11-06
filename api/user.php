<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

#login user
$app->post('/user/login', function(Request $request, Response $response, $args){
    $conn   =$GLOBALS['dbconn'];
    $body   = $request->getBody();
    $bodyArr    = json_decode($body,true);

    $sql    = 'SELECT * FROM `user` WHERE email = ?';
    $stmt   = $conn->prepare($sql);
    $stmt->bind_param("s",$bodyArr['email']);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    // echo $bodyArr['username'];
    // $hash = password_hash($bodyArr['password'],PASSWORD_DEFAULT);
    // echo $hash;
    if($result->num_rows > 0){
        $pwdInDB    = $row["password"];
        if(password_verify($bodyArr['password'],$pwdInDB)){
            $value = array("uid"=>$row['uid'],"check"=>"0");
        }
        else{
            $value = array("check"=>"1");
        }
    }else{
        $value = array("check"=>"2");
    }
    $json = json_encode($value);
    $response->getBody()->write($json);
    return $response->withHeader('Content-Type','application/json');
});

// get data customer
$app->get('/user/{cid}', function(Request $request,Response $response,$args){
    $conn   = $GLOBALS['dbconn'];
    $cid   = $args['cid'];
    $sql    = 'SELECT * from user WHERE uid = ?' ;
    $stmt   =$conn->prepare($sql);
    $stmt->bind_param("i",$cid);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = array();
    while($row = $result->fetch_assoc()){
        array_push($data,$row);
    }
    $json = json_encode($data);
    $response->getBody()->write($json);
    return $response->withHeader('Content-Type','application/json');
});
#regester customer
$app->post('/user/regester', function(Request $request, Response $response, $args){
    $conn   =$GLOBALS['dbconn'];
    $body   = $request->getBody();
    $bodyArr    = json_decode($body,true);
    // echo ('aaaaaaaaaa : '.$bodyArr['password']);
    $pass       =$bodyArr['password'];
    $hashPass   =password_hash($pass,PASSWORD_DEFAULT);

    $sql    = 'SELECT * FROM `user` WHERE email = ?';
    $stmt   = $conn->prepare($sql);
    $stmt->bind_param("s",$bodyArr['email']);
    $stmt->execute();

    $result = $stmt->get_result();
    // echo ('aaaaaaaaaa : '.$result->num_rows);
    // echo $hashPass;
    if($result->num_rows <= 0){
        $sql    = 'INSERT INTO `user`(`username`, `password`, `email`, `birthday`, `phone`) VALUES (?,?,?,?,?)';
        $stmt   = $conn->prepare($sql);
        $stmt->bind_param("sssss",$bodyArr['username'],$hashPass,$bodyArr['email'],$bodyArr['birthday'],$bodyArr['phone']);
        $stmt->execute();

        $value = array("status"=>'0',"result"=>'success');
        $json = json_encode($value);
        $response->getBody()->write($json);
    }
    else{
        $value = array("status"=>'1',"result"=>'fail');
        $json = json_encode($value);
        $response->getBody()->write($json);
    }
    return $response->withHeader('Content-Type','application/json');
    
});
?>