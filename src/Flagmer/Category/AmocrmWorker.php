<?php
namespace Flagmer\Category;

use Flagmer\Integrations\AmoCrm;
use Flagmer\Integrations\Amocrm\sendLeadDto;

class AmocrmWorker extends Category
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function makeAction(string $action) {
        switch ($action)
        {
            case 'sendLead':
                $this->sendLead();
                break;
        }
    }

    private function sendLead()
    {
        $dto = new sendLeadDto();
        $dto->lead_id = $this->id;
        $obj = new AmoCrm();
        $obj->sendLeadAction($dto);
    }
}