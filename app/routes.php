<?php
$app->get('/home',function(){
	return $his->view->render($response,'home.twig') ;
});