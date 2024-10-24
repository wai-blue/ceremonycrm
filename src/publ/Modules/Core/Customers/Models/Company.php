<?php

namespace CeremonyCrmApp\Modules\Core\Customers\Models;

use CeremonyCrmApp\Modules\Core\Billing\Models\BillingAccount;
use CeremonyCrmApp\Modules\Core\Settings\Models\Country;
use CeremonyCrmApp\Modules\Core\Settings\Models\User;
use Illuminate\Database\Eloquent\Builder;

class Company extends \CeremonyCrmApp\Core\Model
{
  public string $table = 'companies';
  public string $eloquentClass = Eloquent\Company::class;
  public ?string $lookupSqlValue = '{%TABLE%}.name';

  public array $relations = [
    'PERSONS' => [ self::HAS_MANY, Person::class, 'id_company' ],
    'COUNTRY' => [ self::HAS_ONE, Country::class, 'id', 'id_country' ],
    'USER' => [ self::BELONGS_TO, User::class, 'id_user', 'id' ],
    'FIRST_CONTACT' => [ self::HAS_ONE, Person::class, 'id_company' ],
    'BILLING_ACCOUNTS' => [ self::HAS_MANY, BillingAccount::class, 'id_company' ],
    'ACTIVITIES' => [ self::HAS_MANY, Activity::class, 'id_company' ],
    'TAGS' => [ self::HAS_MANY, CompanyTag::class, 'id_company', 'id' ],
  ];

  public function columns(array $columns = []): array
  {
    return parent::columns(array_merge($columns, [
      'name' => [
        'type' => 'varchar',
        'title' => 'Name',
        'required' => true,
      ],
      'street_line_1' => [
        'type' => 'varchar',
        'title' => 'Street Line 1',
        'required' => false,
      ],
      'street_line_2' => [
        'type' => 'varchar',
        'title' => 'Street Line 2',
        'required' => false,
      ],
      'region' => [
        'type' => 'varchar',
        'title' => 'Region',
        'required' => false,
      ],
      'city' => [
        'type' => 'varchar',
        'title' => 'City',
        'required' => false,
      ],
      'id_country' => [
        'type' => 'lookup',
        'model' => 'CeremonyCrmApp/Modules/Core/Settings/Models/Country',
        'foreignKeyOnUpdate' => 'CASCADE',
        'foreignKeyOnDelete' => 'SET NULL',
        'title' => 'Country',
        'required' => false,
      ],
      'postal_code' => [
        'type' => 'varchar',
        'title' => 'Postal Code',
        'required' => false,
      ],
      'vat_id' => [
        'type' => 'varchar',
        'title' => 'VAT ID',
        'required' => false,
      ],
      'company_id' => [
        'type' => 'varchar',
        'title' => 'Company ID',
        'required' => false,
      ],
      'tax_id' => [
        'type' => 'varchar',
        'title' => 'Tax ID',
        'required' => false,
      ],
      'note' => [
        'type' => 'text',
        'title' => 'Notes',
        'required' => false,
      ],
      'date_created' => [
        'type' => 'date',
        'title' => 'Date Created',
        'required' => true,
        'readonly' => true,
      ],
      'is_active' => [
        'type' => 'boolean',
        'title' => 'Active',
        'required' => false,
        'default' => 1,
      ],
      'id_user' => [
        'type' => 'lookup',
        'title' => 'Owner',
        'model' => 'CeremonyCrmApp/Modules/Core/Settings/Models/User',
        'foreignKeyOnUpdate' => 'CASCADE',
        'foreignKeyOnDelete' => 'SET NULL',
        'required' => false,
        'default' => 1,
      ]

    ]));
  }

  public function tableDescribe(array $description = []): array
  {
    $description = parent::tableDescribe();
    $description['ui']['title'] = 'Companies';
    $description['ui']['addButtonText'] = 'Add Company';
    $description['ui']['showHeader'] = true;
    $description['ui']['showFooter'] = false;
    unset($description['columns']['street_line_1']);
    unset($description['columns']['street_line_2']);
    unset($description['columns']['city']);
    unset($description['columns']['postal_code']);
    unset($description['columns']['region']);
    unset($description['columns']['id_country']);
    unset($description['columns']['note']);
    unset($description['columns']['note']);
    unset($description['columns']['note']);
    unset($description['columns']['is_active']);
    return $description;
  }

  public function formDescribe(array $description = []): array
  {
    $description = parent::formDescribe();
    $description['defaultValues']['is_active'] = 1;
    $description['includeRelations'] = ['PERSONS', 'COUNTRY', 'FIRST_CONTACT', 'BILLING_ACCOUNTS', 'ACTIVITIES', 'TAGS'];
    return $description;
  }

  public function getNewRecordDataFromString(string $text): array {
    return [
      'name' => $text,
    ];
  }

  public function prepareLoadRecordQuery(array|null $includeRelations = null, int $maxRelationLevel = 0, $query = null, int $level = 0)
  {
    $query = parent::prepareLoadRecordQuery($includeRelations, 3);
    return $query;
  }

}
