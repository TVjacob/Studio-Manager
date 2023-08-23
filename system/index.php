<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require  "logic/controller-user.php";
require  "logic/controller-account.php";
require  "logic/controller-staff.php";
require  "logic/controller-product.php";
require  "logic/controller-transaction.php";
require_once "model/database-config.php";


$request = $_SERVER['REQUEST_URI'];
switch (rewriteurl($request)) {
    case '/index.php':
        findUsers();
        break;
    case '':
        findUsers();
        break;
    case '/':
        findUsers();
        break;
    case '/users':
        findUsers();
        break;
    case '/user':
        userfindByID();
        break;
    case '/deleteuser':
        userdeleteByID();
        break;
    case '/edituser':
        userupdateByID();
        break;
    case '/saveuser':
        saveUser();
        break;
    case '/login':
        authicateUSer();
        break;
    case '/new/product':
        addproduct();
        break;
    case '/edit/product':
        productupdateByID();
        break;
    case '/products':
        findproducts();
        break;
    case '/product':
        productfindByID();
        break;
    case '/productname':
        findProductsName();
        break;
    case '/new/account':
        addAccount();
        break;
    case '/edit/account':
        accountupdateByID();
        break;
    case '/accounts':
        findaccounts();
        break;
    case '/account':
        accountfindByID();
        break;
    case '/accountcode':
        accountfindByaccountcode($_SERVER['REQUEST_URI']);
        break;
    case '/accounttypes':
        findaccounttypes();
        break;

    case '/new/staff':
        addstaff();
        break;
    case '/edit/staff':
        staffupdateByID();
        break;
    case '/staffs':
        findstaffs();
        break;
    case '/staff':
        stafffindByID();
        break;
    case '/new/payment':
        addTransaction();
        break;
    case '/edit/transaction':
        transactions();
        break;
    case '/transactions':
        findTransactions();
        break;
    case '/transaction':
        findTransactionsByID();
        break;
    case '/staff/transaction':
        findTransactionsBystaffID();
        break;
    case '/details/payment':
        getTransactionBydetails();
        break;
    default:
        echo json_encode(array("message" => "file not found ... "));
}


function rewriteurl($str)
{
    $str=str_replace("/system","",$str);
    if (strpos($str, "?")) {
        $var = strpos($str, "?");
        $len = strlen($str);//length
        $url = substr($str, 0, $var);
        return $url;
    } else {
        return $str;
    }
}
