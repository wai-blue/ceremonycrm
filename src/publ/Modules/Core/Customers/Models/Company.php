<?php

namespace CeremonyCrmApp\Modules\Core\Customers\Models;

class Company extends \CeremonyCrmApp\Core\Model
{
  public string $fullTableSqlName = 'companies';
  public string $table = 'companies';
  public string $eloquentClass = Eloquent\Company::class;
  public ?string $lookupSqlValue = "{%TABLE%}.name";

  public function columns(array $columns = []): array
  {
    return parent::columns(array_merge($columns, [
      "name" => [
        "type" => "varchar",
        "title" => "Name",
      ],
    ]));
  }

  public function tableParams(array $params = []): array
  {
    $params = parent::tableParams();
    $params['title'] = 'Companies';
    return $params;
  }

}
