<?php
namespace Flagmer\Category;

use Exception;

class CategoryFactory
{
    public static function createCategory(string $category, object $initData) : Category
    {
        switch ($category)
        {
            case 'amocrm':
                return new AmocrmWorker($initData->lead_id);
            case "account":
                return new AccountWorker($initData->account_id, $initData->amount);
            default:
                throw new Exception("Unknown category type: " . $category);
        }
    }
}
