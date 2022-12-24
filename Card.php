<?php

class Card
{
    private $cardNumber;
    private $hashPin;
    private $accountNumber;
    private $cardIsActive;
    public function __construct($cardNumber, $pin, $accountNumber)
    {
        $this->cardNumber = $cardNumber;
        $this->hashPin = hash('ripemd160', $pin);
        $this->accountNumber = $accountNumber;
        $this->cardIsActive = false;
    }


    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    public function checkPin($pin)
    {
        $givenPin = hash('ripemd160', $pin);
        return ($givenPin == $this->hashPin);
    }

    public function activateCard($pin)
    {
        if ($this->checkPin($pin)){
            $this->cardIsActive = true;
        }
        else{
            throw new InvalidArgumentException("Invalid pin");
        }
    }

    public function deactivateCard()
    {
        $this->cardIsActive = false;
    }

    public function getActiveCard()
    {
        return $this->cardIsActive;
    }

}