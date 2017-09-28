<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app = new \Slim\App;
// select everything
$app->get('/app/customers',function(Request $request , Response $response){
$sql = "SELECT * FROM customers";
try{
	$db = new db();
	$db = $db->connect();
	$stmt = $db->query($sql);
	$customers = $stmt->fetchALL(PDO::FETCH_OBJ);
	$db = null;
	echo json_encode($customers);

}catch(PDOException $e){
	echo '{"error": {"text": '.$e->getMessage().'}}';
}

});

// select by id
$app->get('/app/customer/{id}',function(Request $request , Response $response){
	$id = $request->getAttribute('id');
	$sql = "SELECT * FROM customers WHERE id=$id";
try{
	$db = new db();
	$db = $db->connect();
	$stmt = $db->query($sql);
	$customer = $stmt->fetchALL(PDO::FETCH_OBJ);
	$db = null;
	echo json_encode($customer);

}catch(PDOException $e){
	echo '{"error": {"text": '.$e->getMessage().'}}';
}

});

//add customers
$app->post('/app/customer/add',function(Request $request , Response $response){
	$first_name = $request->getParam('first_name');
	$last_name = $request->getParam('last_name');
	$phone = $request->getParam('phone');
	$email = $request->getParam('email');
	$address = $request->getParam('address');
	$city = $request->getParam('city');
	$state = $request->getParam('state');



	$sql = "INSERT INTO customers (first_name,last_name,phone,email,address,city,state) VALUES (:first_name,:last_name,:phone,:email,:address,:city,:state)";
try{
	$db = new db();
	$db = $db->connect();
	$stmt = $db->prepare($sql);
		
	$stmt = $db->prepare($sql);
	$stmt->blindparam(':first_name', $first_name);
	$stmt->blindparam(':last_name', $last_name);
	$stmt->blindparam(':phone', $phone);
	$stmt->blindparam(':email', $email);
	$stmt->blindparam(':address', $address);
	$stmt->blindparam(':city', $city);
	$stmt->blindparam(':state', $state);
	$stmt->execute();

	echo '{"notice": {"text": "Customer Added"}}';
}catch(PDOException $e){
	echo '{"error": {"text": '.$e->getMessage().'}}';
}

});

