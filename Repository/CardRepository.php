<?php

require_once "Repository.php";

class CardRepository extends Repository
{
    private $accountRepository;
    private $cards;

    public function __construct($accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

	public function add($card)
    {
        $this->cards[$card->getCardNumber()] = $card;
	}
	
	public function getItem($key)
    {
        if (!array_key_exists($key, $this->cards)){
            throw new InvalidArgumentException($message="Invalid key");
        }
        return $this->cards[$key];
	}
}