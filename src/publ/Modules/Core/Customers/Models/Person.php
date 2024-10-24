<?php

namespace CeremonyCrmApp\Modules\Core\Customers\Models;

use Illuminate\Database\Eloquent\Builder;

class Person extends \CeremonyCrmApp\Core\Model
{
  public string $table = 'persons';
  public string $eloquentClass = Eloquent\Person::class;
  public ?string $lookupSqlValue = "concat({%TABLE%}.first_name, ' ', {%TABLE%}.last_name)";

  public array $relations = [
    'COMPANY' => [ self::BELONGS_TO, Company::class, 'id_company' ],
    'CONTACTS' => [ self::HAS_MANY, Contact::class, 'id_person', 'id' ],
    'ADDRESSES' => [ self::HAS_MANY, Address::class, 'id_person', 'id' ],
    'TAGS' => [ self::HAS_MANY, PersonTag::class, 'id_person', 'id' ],
  ];

  public function columns(array $columns = []): array
  {
    return parent::columns(array_merge($columns, [
      'first_name' => [
        'type' => 'varchar',
        'title' => 'First name',
        'required' => true,
      ],
      'last_name' => [
        'type' => 'varchar',
        'title' => 'Last name',
        'required' => true,
      ],
      'id_company' => [
        'type' => 'lookup',
        'title' => 'Company',
        'model' => 'CeremonyCrmApp/Modules/Core/Customers/Models/Company',
        'foreignKeyOnUpdate' => 'CASCADE',
        'foreignKeyOnDelete' => 'CASCADE',
        'required' => true,
      ],
      'is_primary' => [
        'type' => 'boolean',
        'title' => 'First Contact',
      ],
      'note' => [
        'type' => 'text',
        'title' => 'Notes',
        'required' => false,
      ],
      'is_active' => [
        'type' => 'boolean',
        'title' => 'Active',
        'required' => false,
        'default' => 1,
      ],
    ]));
  }

  public function tableDescribe(array $description = []): array
  {
    $description = parent::tableDescribe();
    $description['title'] = 'Contact Persons';
    $description['ui']['addButtonText'] = 'Add Contact Person';
    $description['ui']['showHeader'] = true;
    $description['ui']['showFooter'] = false;
    return $description;
  }

  public function formDescribe(array $description = []): array
  {
    $description = parent::formDescribe();
    $description['defaultValues']['is_active'] = 1;
    $description['defaultValues']['is_primary'] = 0;
    $description['includeRelations'] = ['ADDRESSES', 'CONTACTS', 'TAGS'];
    return $description;
  }

  public function prepareLoadRecordQuery(array|null $includeRelations = null, int $maxRelationLevel = 0, $query = null, int $level = 0)
  {
    $query = parent::prepareLoadRecordQuery($includeRelations, 1);

    $query = $query->selectRaw("
      (Select value from contacts where id_person = persons.id and type = 'number' LIMIT 1) virt_number,
      (Select value from contacts where id_person = persons.id and type = 'email' LIMIT 1) virt_email,
      (Select concat(street_line_1,', ', street_line_2, ', ', city) from addresses where id_person = persons.id LIMIT 1) virt_address
    ");

    return $query;
  }
}
