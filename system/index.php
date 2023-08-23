<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require  "logic/controller-user.php";
require  "logic/controller-student.php";
require  "logic/controller-account.php";
require  "logic/controller-staff.php";
require  "logic/controller-expense.php";
require  "logic/controller-payment.php";
require  "logic/controller-schoolTerm.php";
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
    case '/new/student':
        addstudent();
        break;
    case '/edit/student':
        studentupdateByID();
        break;
    case '/students':
        findstudents();
        break;
    case '/student':
        studentfindByID();
        break;
    case '/enrollments':
        enrollments();
        break;
    case '/enroll/student':
        enrollStudent();
        break;
    case '/edit/enroll/student':
        addAccount();
        break;
    case '/enroll/student_id':
        findEnrollId();
        break;
    case '/enroll/student_code':
        findEnrolledStudent();
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
        addPayment();
        break;
    case '/edit/payment':
        editPayment();
        break;
    case '/payments':
        findPayments();
        break;
    case '/payment':
        findPaymentsByID();
        break;
    case 'staff/payment':
        findPaymentsByID();
        break;
    case 'stu/payment':
        findPaymentsByID();
        break;
    case '/new/expense':
        addExpense();
        break;
    case '/edit/expense':
        editExpense();
        break;
    case '/expenses':
        findExpenses();
        break;
    case '/expense':
        findExpensesByID();
        break;
    case 'staff/expense':
        findExpensesByID();
        break;
    case 'stu/expense':
        findExpensesByID();
        break;
    case '/new/term':
        addTerm();
        break;
    case '/edit/term':
        updateTermByID();
        break;
    case '/terms':
        getTerms();
        break;
    case '/term':
        findschoolTermByID();
        break;
    case '/activeperiod':
        activePeriod();
        break;

    default:
        echo json_encode(array("message" => "file not found ... "));
}


function rewriteurl($str)
{
    if (strpos($str, "?")) {
        $var = strpos($str, "?");
        $len = strlen($str);
        $url = substr($str, 0, $var);
        return $url;
        // echo "$url";
    } else {
        return $str;
    }
}


// configStr($request);
