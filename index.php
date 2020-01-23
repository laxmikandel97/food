<?php
/**
 * Laxmi Kandel
 * 01/15/2020
 * /IT328/chicken/index.php
 */


//session
session_start();
//TURN ON ERROR REPORTING

ini_set("display_errors", 1);
error_reporting(E_ALL);

//session start() wont work if there is space or any echo statement after php or before php
//session_start();

require "vendor/autoload.php";

//Instantiate F3
$f3 = Base::instance();
//defining a default route
//it means when the user navigate through root directory (chicken) they should see the output
//we wont have index.php

$f3->route('GET /',function ()
{
    $view = new Template();//template object
    echo $view-> render('views/home.html');//use it to render the main page
//    echo "Hello Food!";
});

//define a breakfast route
$f3->route('GET /breakfast', function (){
$view = new Template();
echo $view->render('views/breakfast.html');
});


//define lunch route
$f3->route('GET /lunch', function ()
{
    $view=new Template();
    echo $view->render('views/lunch.html');
});


//Define a route that accepts a food parameter
//specific FOOD
$f3->route('GET /@item', function ($f3,$prams)
{
    var_dump($prams);
    $item =$prams['item'];
    echo"<p> You ordered $item</p>";
    $foodWebServe = array("tacos","pizza","lumpia");
    if(!in_array($item,$foodWebServe))
    {
        echo "<p> Sorry we don't serve $item</p>";
    }
    switch ($item)
    {
        case 'tacos':
            echo "<p> We serve tacos on Tuesdays</p>";
            break;
        case 'pizza':
            echo "<p>Pepperoni or veggie?</p>";
            break;
        case 'bagels':
            $f3->reroute("/breakfast");
        default:
            $f3->error(404);
    }
});

//Defining a order route
$f3->route('GET /order', function (){
    $view = new Template();
    echo $view->render('views/form1.html');
});


//Defining a order2 route
$f3->route('POST /order2', function (){
    //var dump($_POST);
    $_SESSION['food']=$_POST['food'];
    $view = new Template();
    echo $view->render('views/form2.html');
});

$f3->route('POST /order3', function (){
    //var dump($_POST);
    $_SESSION['meal']=$_POST['meal'];
    $view = new Template();
    echo $view->render('views/form3.html');
});

$f3->route('POST /summary', function (){
    $_SESSION['size'] = $_POST['size'];
    $_SESSION['beverage'] = $_POST['beverage'];
    $view = new Template();
    echo $view->render('views/result.html');
});
//Run fat free
$f3-> run();
