<?php

class Account
{
    private $accountNumber;
    private $amount;

    public function __construct($accountNumber, $amount)
    {
        $this->accountNumber = $accountNumber;
        $this->amount = $amount;
    }

    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    public function  getAmount($card)
    {
        if ($card->getActiveCard())
            return $this->amount;
    }

    public function addMoney($card, $cash)
    {
        if ($card->getActiveCard())
            $this->amount += $cash;
        else
            throw new LogicException("Card in none active");
    }

    public function takeMoney($card, $cash)
    {
        if ($card->getActiveCard())
            $this->amount -= $cash;
        else
            throw new LogicException("Card in none active");
    }

}