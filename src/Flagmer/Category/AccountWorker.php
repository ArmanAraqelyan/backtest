<?php
namespace Flagmer\Category;

use Flagmer\Billing\Account\processPaymentDto;
use Flagmer\Billing\Account;

class AccountWorker extends Category 
{
    private $account_id;
    private $amount;

    public function __construct($account_id, $amount)
    {
        $this->amount = $amount;
        $this->account_id = $account_id;
    }

    public function makeAction(string $action)
    {
        switch ($action)
        {
            case 'processPayment':
                $this->processPayment();
                break;
        }
    }

    private function processPayment()
    {
        $dto = new processPaymentDto();
        $dto->account_account_id = $this->account_id;
        $dto->amount = $this->amount;

        $obj = new Account();
        $obj->processPaymentAction($dto);
    }
}