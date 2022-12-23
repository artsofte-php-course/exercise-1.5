<?php

class Card
{
    public $number;
    public $pin;
    public $accountNumber;

    public function __construct($number, $pin, $accountNumber)
    {
        $this->number = $number;
        $this->pin = $pin;
        $this->accountNumber = $accountNumber;
    }
}

class Account
{
    public $number;
    public $amount;

    public function __construct($number, $amount)
    {
        $this->number = $number;
        $this->amount = $amount;
    }

    public function cashOut($sum)
    {
        $this->amount -= $sum;
    }

    public function cashIn($sum)
    {
        $this->amount += $sum;
    }
}

class AccountRepository
{

    public $accounts;

    public function __construct(...$accounts)
    {
        foreach ($accounts as $account)
            $this->accounts[$account->number] = $account;
    }

    public function add($account)
    {
        $this->accounts[$account->number] = $account;
    }

    public function getAccount($number)
    {
        return $this->accounts[$number];
    }
}

class CardRepository
{

    public $cards;

    public function __construct(...$cards)
    {
        foreach ($cards as $card)
            $this->cards[$card->number] = $card;
    }

    public function add($card)
    {
        $this->cards[$card->number] = $card;
    }

    public function getCard($number)
    {
        return $this->cards[$number];
    }
}


class ATM
{
    private $accountRepository;
    private $cardRepository;
    private $currentCard;
    private $currentAccount;
    private $isCorrectPin;

    public function __construct($accountRepository, $cardRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->cardRepository = $cardRepository;
    }

    public function insertCard($cardNumber)
    {
        $this->currentCard = $this->cardRepository->getCard($cardNumber);
        $this->currentAccount = $this->accountRepository->getAccount($this->currentCard->accountNumber);
    }

    public function enterPin($pin)
    {

        $this->isCorrectPin = $pin === $this->currentCard->pin;
        echo($this->isCorrectPin ? "Верный PIN\n" : "Неверный PIN\n");
    }

    public function cashOut($sum)
    {
        if ($this->isCorrectPin and $this->currentAccount->amount - $sum >= 0) {
            $this->currentAccount->cashOut($sum);
        } else {
            echo("Ошибка");
        }
    }

    public function cashIn($sum)
    {
        if ($this->isCorrectPin) {
            $this->currentAccount->cashIn($sum);
        } else {
            echo("Ошибка");
        }
    }

    public function balance()
    {
        return $this->currentAccount->amount;
    }

    public function finish()
    {
        $this->isCorrectPin = false;
    }
}


// Создание репозитория счетов
$accountRepository = new AccountRepository();

// Создание репозитория карт
$cardRepository = new CardRepository();


// номер счета
$accountNumber = "3000400050006000";
// количество средств на счете
$amount = 10000;

// Добавление счета
$accountRepository->add(new Account($accountNumber, $amount));

// Номер карты
$cardNumber = "4444-5555-5555-5555";

// Пинкод
$pin = "1234";

// Добавление карты
$cardRepository->add(new Card($cardNumber, $pin, $accountNumber));

//Создание класса банкомата
$atm = new ATM($accountRepository, $cardRepository);

//Вставляем карту в приемник
$atm->insertCard($cardNumber);

//Указываем пинкод, если пинкод не подходит, выдаем ошибку
$atm->enterPin($pin);

//Получение средств,
// Если средств недостаточно, ошибка
// Если карта не вставлена или не указан пинкод, то также ошибка

$atm->cashOut(1000);
//Снятие средств, ошибки аналогично если карта не вставлена или пинкод не прошел проверку
$atm->cashIn(500);

// Получение баланса, должно вывести 10000-1000+500 = 9500;
echo $atm->balance();

//Завершение работы, забираем карту
$atm->finish();