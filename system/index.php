<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require  "logic/controller-user.php";
require  "logic/controller-account.php";
require  "logic/controller-staff.php";
require  "logic/controller-product.php";
require  "logic/controller-customer.php";
require  "logic/controller-gl_transaction.php";
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
    case '/new/customer':
        addcustomer();
        break;
    case '/edit/customer':
        customerupdateByID();
        break;
    case '/customers':
        findcustomers();
        break;
    case '/customer':
        customerfindByID();
        break;
    case '/customer/name':
        findCustomersName();
        break;
    case '/new/bill':
        saveBill();
        break;
    case '/bill/payment':
        saveRecipt();
        break;
    case '/new/salary/payment':
        saveSalary();
        break;
    case '/new/payment':
        saveDoubleEntry();
        break;
    case '/find/bills':
        billings();
        break;
    case '/find/balances':
        balances();
        break;
    case '/find/recipts':
        payments();
        break;
    case '/find/transactions':
        findTransactions();
        break;
    case '/find/salary/payments':
        salarypayments();
        break;
    case '/find/payment/id':
        findTransactionsByID();
        break;
    case '/find/payment/referid':
        findTransactionsByreferID();
        break;
    case '/delete/payment/id':
        deleteTransactionByID();
        break;
    case '/delete/allpayment/id':
        deleteTransactionByreferID();
        break;
        case '/report/customer':
            header('Location: /report/customers-report.php'); 
            exit();
            break;
    default:
        echo json_encode(array("message" => "file not found ... "));
}


function rewriteurl($str)
{
    $str = str_replace("/system", "", $str);
    if (strpos($str, "?")) {
        $var = strpos($str, "?");
        $len = strlen($str); //length
        $url = substr($str, 0, $var);
        return $url;
    } else {
        return $str;
    }
}
