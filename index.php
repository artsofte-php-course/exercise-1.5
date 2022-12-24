<?php

require_once "Repository/AccountRepository.php";
require_once "Repository/CardRepository.php";
require_once "Account.php";
require_once "ATM.php";
require_once "Card.php";


// Создание репозитория счетов
$accountRepository = new AccountRepository();

// Создание репозитория карт
$cardRepository = new CardRepository($accountRepository);

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