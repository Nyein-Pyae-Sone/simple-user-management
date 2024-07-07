<?php

function setError($message)
{
    $_SESSION['errors'] = [];
    $_SESSION['errors'][] = $message;
}

function showError()
{
    if(isset($_SESSION['errors'])){
        $errors = $_SESSION['errors'];
        $_SESSION['errors'] = [];
        if(count($errors)){
            foreach ($errors as $e){
                echo "<div class='text-danger'>$e</div>";    
            }
        }
    }
    
}
function setMsg($message)
{
    $_SESSION['msg'] = [];
    $_SESSION['msg'][] = $message;
}

function showMsg()
{
    if(isset($_SESSION['msg'])){
        $msg = $_SESSION['msg'];
        $_SESSION['msg'] = [];
        if(isset($_SESSION['msg']) and count($msg)){
            foreach ($msg as $e){
                echo "<div class='text-success'>$e</div>";
            }
        }
    }
    
}

function hasError()
{
    $errors = $_SESSION['errors'];
    if(count($errors)){
        return true;
    }
    return false;
}

function go($path)
{
    header("Location:$path");
}

// In init.php or a similar common file
function ensureLoggedIn() {
    if (!isset($_SESSION['user'])) {
        setError('Please login first');
        go('/login.php');
        exit(); // Make sure to exit after the redirect to stop further script execution
    }
}

function dd($vaule)
{
    echo "<pre>";
    var_dump($vaule);
    echo "</pre>";
    die();
}