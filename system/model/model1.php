<?php
class Student
{
    public $name;
    public $sclass;
    public $dob;
    private $studentCode;
    public $address;
    public $parents;
    public $phoneno;


    public function __construct($name, $studentCode, $sclass, $dob, $address, $parents, $phoneno)
    {
        $this->name = $name;
        $this->sclass = $sclass;
        $this->dob = $dob;
        $this->address = $address;
        $this->parents = $parents;
        $this->phoneno = $phoneno;
        $this->studentCode = $studentCode;
    }
    public function get_StudnetCode()
    {
        return $this->studentCode;
    }
    public function set_StudnetCode($studentCode)
    {
        $this->studentCode = $studentCode;
    }
    public function get_name()
    {
        return $this->name;
    }
    public function get_Class()
    {
        return $this->sclass;
    }
    public function get_Dob()
    {
        return $this->dob;
    }
    public function get_Parents()
    {
        return $this->parents;
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


class AccountType
{
    private $id;
    public $name;
    public $isincome;
    public $balanceSheet;
    public $accountcode;

    public function __construct($accountcode, $name, $isincome, $balanceSheet)
    {
        $this->accountcode = $accountcode;
        $this->isincome = $isincome;
        $this->balanceSheet = $balanceSheet;
        $this->name = $name;
    }
    public function get_ID()
    {
        return $this->id;
    }
    public function setID($id)
    {
        $this->id = $id;
    }
}

class schoolTerm
{
    public $id;
    public $term_status;
    public  $term_end;
    public  $term_start;

    public function  __construct($term_status, $term_end, $term_start)
    {
        $this->term_status = $term_status;
        $this->term_start = $term_start;
        $this->term_end = $term_end;
    }
}
