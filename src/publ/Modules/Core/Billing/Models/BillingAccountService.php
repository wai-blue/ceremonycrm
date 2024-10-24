<?php

namespace CeremonyCrmApp\Modules\Core\Billing\Models;

use CeremonyCrmApp\Modules\Core\Services\Models\Service;

class BillingAccountService extends \CeremonyCrmApp\Core\Model
{
  public string $table = 'billing_accounts_services';
  public string $eloquentClass = Eloquent\BillingAccountService::class;

  public array $relations = [
    'SERVICE' => [ self::BELONGS_TO, Service::class, 'id_service', 'id' ],
    'BILLING_ACCOUNT' => [ self::BELONGS_TO, BillingAccount::class, 'id_billing_account', 'id' ],
  ];

  public function columns(array $columns = []): array
  {
    return parent::columns(array_merge($columns, [
      'id_billing_account' => [
        'type' => 'lookup',
        'title' => 'Billing Account',
        'model' => 'CeremonyCrmApp/Modules/Core/Billing/Models/BillingAccount',
        'foreignKeyOnUpdate' => 'CASCADE',
        'foreignKeyOnDelete' => 'CASCADE',
        'required' => true,
      ],
      'id_service' => [
        'type' => 'lookup',
        'title' => 'Service',
        'model' => 'CeremonyCrmApp/Modules/Core/Services/Models/Service',
        'foreignKeyOnUpdate' => 'CASCADE',
        'foreignKeyOnDelete' => 'CASCADE',
        'required' => true,
      ],
    ]));
  }

  public function tableDescribe(array $description = []): array
  {
    $description = parent::tableDescribe();
    $description['ui']['title'] = 'Connected Services';
    $description['ui']['addButtonText'] = 'Connect a Service';
    $description['ui']['showHeader'] = true;
    $description['ui']['showFooter'] = false;
    return $description;
  }

}
