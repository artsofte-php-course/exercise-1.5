<?php

require_once "Repository.php";

class AccountRepository extends Repository
{
    private $accounts = [];
	
	public function add($account) 
    {
        $this->accounts[$account->getAccountNumber()] = $account;
	}
	
	public function getItem($accountNumber)
    {
        return $this->accounts[$accountNumber];
	}
}