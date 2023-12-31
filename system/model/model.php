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
class transactionaltracker{
    public $id;
    public $screen_details;
    public function __construct($id,$screen_details)
    {
        $this->id=$id;
        $this->screen_details=$screen_details;
        
    }


}
class GL_Transaction
{
    private $id;
    public $customer_id=null;
    public $screen_details=null;
    public  $remarks=null;
    public  $staff_id=null;
    public  $product_id=null;
    public  $transDate;
    public   $amount = 0;
    public $creditaccount_id=null;
    public  $debitaccount_id=null;
    public $reference_id;



    public function __construct($reference_id, $customer_id, $screen_details, $remarks, $transDate, $amount, $creditaccount, $debitaccount_id, $product_id, $staff_id)
    {
        $this->reference_id = $reference_id;
        $this->screen_details = $screen_details;
        $this->customer_id = $customer_id;
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
