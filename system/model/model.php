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
class Payment
{
    private $id;
    public  $debitaccount_id;
    public  $details;
    public  $remarks;
    public  $staff_id;
    public  $student_id;
    public  $transDate;
    public  $term_id;
    public  $amount;
    public $creditaccount_id;


    public function __construct($details, $remarks, $transDate, $amount, $creditaccount, $debitaccount_id, $student_id, $staff_id, $term_id)
    {
        $this->details = $details;
        $this->remarks = $remarks;
        $this->creditaccount_id = $creditaccount;
        $this->debitaccount_id = $debitaccount_id;
        $this->student_id = $student_id;
        $this->staff_id = $staff_id;
        $this->term_id = $term_id;
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
class Expense
{
    private $id;
    public  $debitaccount_id;
    public  $creditaccount_id;

    public  $details;
    public  $remarks;
    public  $staff_id;
    public  $student_id;
    public  $transDate;
    public  $term_id;
    public  $amount;


    public function __construct($details, $remarks, $transDate, $amount, $debitaccount_id, $creditaccount_id, $student_id, $staff_id, $term_id)
    {
        $this->details = $details;
        $this->remarks = $remarks;
        $this->debitaccount_id = $debitaccount_id;
        $this->creditaccount_id = $creditaccount_id;
        $this->student_id = $student_id;
        $this->staff_id = $staff_id;
        $this->term_id = $term_id;
        $this->amount = $amount;
        $this->transDate = $transDate;
        $this->amount = $amount;
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
}

class Enroll
{
    private $id;
    public  $student_id;
    public $term_id;
    public DateTime $term_end;
    public DateTime $term_start;
    public float $amount = 0;




    public function __construct($term_end, $term_start, $amount, $student_id, $term_id)
    {
        $this->term_end = $term_end;
        $this->term_start = $term_start;
        $this->student_id = $student_id;
        $this->term_id = $term_id;
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

class GeneralTransaction
{
    private $id;
    public  $student_id;
    public  $staff_id;
    public $term_id;
    public float $amount = 0;
    public $transtype;
    public $details;
    public $remarks;
    public DateTime $transdate;
    public $account_id;
    public $reference_id;

    public function __construct($account_id, $transdate, $remarks, $details, $transtype, $amount, $student_id, $term_id, $reference_id,$staff_id)
    {
        $this->staff_id=$staff_id;
        $this->account_id = $account_id;
        $this->transdate = $transdate;
        $this->remarks = $remarks;
        $this->details = $details;
        $this->transtype = $transtype;
        $this->student_id = $student_id;
        $this->term_id = $term_id;
        $this->amount = $amount;
        $this->reference_id = $reference_id;
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
