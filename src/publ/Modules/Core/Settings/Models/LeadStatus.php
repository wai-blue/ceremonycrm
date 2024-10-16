<?php

namespace CeremonyCrmApp\Modules\Core\Settings\Models;

class LeadStatus extends \CeremonyCrmApp\Core\Model
{
  public string $table = 'lead_statuses';
  public string $eloquentClass = Eloquent\LeadStatus::class;
  public ?string $lookupSqlValue = '{%TABLE%}.name';

  public function columns(array $columns = []): array
  {
    return parent::columns(array_merge($columns, [
      'name' => [
        'type' => 'varchar',
        'title' => 'Name',
        'required' => true,
      ],
      'order' => [
        'type' => 'int',
        'title' => 'Order',
        'required' => true,
      ],
      'color' => [
        'type' => 'color',
        'title' => 'Color',
        'required' => false,
      ],
    ]));
  }

  public function tableDescribe(array $description = []): array
  {
    $description = parent::tableDescribe();
    $description['title'] = 'Lead Statuses';
    return $description;
  }

  /* public function prepareLoadRecordQuery(?array $includeRelations = null, int $maxRelationLevel = 0, $query = null, int $level = 0)
  {
    $query = parent::prepareLoadRecordQuery();
    $query->orderBy("order", "asc");
    return $query;
  } */

}
