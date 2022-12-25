class Bank {
  private $name;
  private $accounts;

  public function __construct($name) {
    $this->name = $name;
    $this->accounts = array();
  }

  public function getName() {
    return $this->name;
  }

  public function createAccount($accountNumber, $password) {
    $this->accounts[$accountNumber] = new Account($accountNumber, $password);
  }

  public function getAccount($accountNumber, $password) {
    if (!isset($this->accounts[$accountNumber])) {
      return null;
    }
    $account = $this->accounts[$accountNumber];
    if ($account->checkPassword($password)) {
      return $account;
    }
    return null;
  }
}

class Account {
  private $accountNumber;
  private $password;
  private $balance;

  public function __construct($accountNumber, $password) {
    $this->accountNumber = $accountNumber;
    $this->password = $password;
    $this->balance = 0;
  }

  public function getAccountNumber() {
    return $this->accountNumber;
  }

  public function checkPassword($password) {
    return $this->password == $password;
  }

  public function getBalance() {
    return $this->balance;
  }

  public function deposit($amount) {
    $this->balance += $amount;
  }

  public function withdraw($amount) {
    if ($amount > $this->balance) {
      return false;
    }
    $this->balance -= $amount;
    return true;
  }
}

class ATM {
  private $bank;

  public function __construct(Bank $bank) {
    $this->bank = $bank;
  }

  public function login($accountNumber, $password) {
    return $this->bank->getAccount($accountNumber, $password);
  }

  public function deposit($accountNumber, $password, $amount) {
    $account = $this->login($accountNumber, $password);
    if ($account == null) {
      return false;
    }
    $account->deposit($amount);
    return true;
  }

  public function withdraw($accountNumber, $password, $amount) {
    $account = $this->login($accountNumber, $password);
    if ($account == null) {
      return false;
    }
    return $account->withdraw($amount);
  }

  public function getBalance($accountNumber, $password) {
    $account = $this->login($accountNumber, $password);
    if ($account == null) {
      return false;
    }
    return $account->getBalance();
  }
}
