<?php

class ATM
{
    private $accountRepository;
    private $cardRepository;
    private $activeCard;
    private $confirmedPin;

    public function __construct($accountRepository, $cardRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->cardRepository = $cardRepository;   
    }

    public function insertCard($cardNumber)
    {
        if (!empty($this->activeCard)){
            throw new InvalidArgumentException("Card already exists in ATM");
        }

        $this->activeCard = $this->cardRepository->getItem($cardNumber);
    }

    public function enterPin($pin)
    {
        $this->activeCard->activateCard($pin);
        if (!$this->activeCard->getActiveCard()){
            throw new LogicException("Card none active");
        }elseif (!$this->activeCard->checkPin($pin)){
            throw new LogicException("Uncorrect pin");
        }
        $this->confirmedPin = true;
    }

    public function cashIn($cash)
    {
        if (!$this->activeCard->getActiveCard()){
            throw new LogicException("Card in none active");
        }
        else{
            $account = $this->accountRepository->getItem($this->activeCard->getAccountNumber());
            $account->addMoney($this->activeCard, $cash);
        }
    }

    public function cashOut($cash)
    {
        if (!$this->activeCard->getActiveCard()){
            throw new LogicException("Card in none active");
        }
        else{
            $account = $this->accountRepository->getItem($this->activeCard->getAccountNumber());
            $account->TakeMoney($this->activeCard, $cash);
        }
    }

    public function balance()
    {
        if (!$this->activeCard->getActiveCard()){
            throw new LogicException("Card in none active");
        } else {
            $account = $this->accountRepository->getItem($this->activeCard->getAccountNumber());
            return $account->getAmount($this->activeCard);
        }
    }

    public function finish()
    {
        $this->activeCard->deactivateCard();
        $this->activeCard = null;
    }

}