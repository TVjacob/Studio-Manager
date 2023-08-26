<?php
class User
{
    private $id;
    private $username;
    private $password;
    private $email;
    private $tdate;
    private $islogged;


    public function __construct($username, $password, $email, $islogged)
    {
        $this->username = $username;
        $this->password = $password;
        $this->islogged = $islogged;
        $this->email = $email;
        // $this->id=$id;
    }
    public function setID($id)
    {
        return $this->id = $id;
    }
    public function getID()
    {
        return $this->id;
    }




    public function getemail()
    {
        return $this->email;
    }
    public function getusername()
    {
        return $this->username;
    }
    public function getpassword()
    {
        return $this->password;
    }
    public function getdate()
    {
        return $this->tdate;
    }
    public function getislogged()
    {
        return $this->username;
    }
}
class Staff
{
    private $name;
    private $dob;
    private $staffCode;
    private $address;
    private $role;
    private $phoneno;
    private $salary  = 0;


    public function __construct($name, $staffCode, $role, $dob, $address, $salary, $phoneno)
    {
        $this->name = $name;
        $this->role = $role;
        $this->dob = $dob;
        $this->address = $address;
        $this->salary = $salary;
        $this->phoneno = $phoneno;
        $this->staffCode = $staffCode;
    }
    public function set_staffCode($staffCode)
    {
        $this->staffCode = $staffCode;
    }
    public function get_Salary()
    {
        return $this->salary;
    }
    public function get_name()
    {
        return $this->name;
    }
    public function get_Staffcode()
    {
        return $this->staffCode;
    }
    public function get_Dob()
    {
        return $this->dob;
    }
    public function get_Role()
    {
        return $this->role;
    }
    public function get_Address()
    {
        return $this->address;
    }
    public function get_Phone()
    {
        return $this->phoneno;
    }
}
class Transaction
{
    private $id;
    public  $details;
    public  $remarks;
    public  $staff_id;
    public  $product_id;
    public  $transDate;
    public  float $amount = 0;
    public $creditaccount_id;
    public  $debitaccount_id;



    public function __construct($details, $remarks, $transDate, $amount, $creditaccount, $debitaccount_id, $product_id, $staff_id)
    {
        $this->details = $details;
        $this->remarks = $remarks;
        $this->creditaccount_id = $creditaccount;
        $this->debitaccount_id = $debitaccount_id;
        $this->product_id = $product_id;
        $this->staff_id = $staff_id;
        $this->amount = $amount;
        $this->transDate = $transDate;
        $this->amount = $amount;
    }

    public function setID($id)
    {
        return $this->id = $id;
    }
    public function getID()
    {
        return $this->id;
    }
}
class Product
{
    private $id;
    public $productname;
    public int $rate = 0;
    public float $amount = 0;
    public $units;

    public function __construct($productname, $rate, $amount, $units)
    {
        $this->productname = $productname;
        $this->rate = $rate;
        $this->amount = $amount;
        $this->units = $units;
    }
    public function setID($id)
    {
        return $this->id = $id;
    }
    public function getID()
    {
        return $this->id;
    }
}

class Account
{
    private $id;
    public  $acountCode;
    public $accountName;
    public  $account_type;
    public $isincome;



    public function __construct($acountCode, $accountName, $account_type, $isincome)
    {
        $this->acountCode = $acountCode;
        $this->accountName = $accountName;
        $this->account_type = $account_type;
        $this->isincome = $isincome;
    }


    public function setID($id)
    {
        return $this->id = $id;
    }
    public function getID()
    {
        return $this->id;
    }
}

class Customer
{
    private $id;
    public $customername;
    public $address;
    public $phoneno;
    public $emailaddress;

    public function __construct($customername, $address, $phoneno, $emailaddress)
    {
        $this->customername = $customername;
        $this->address = $address;
        $this->phoneno = $phoneno;
        $this->emailaddress = $emailaddress;
    }
    public function setID($id)
    {
        return $this->id = $id;
    }
    public function getID()
    {
        return $this->id;
    }
}
