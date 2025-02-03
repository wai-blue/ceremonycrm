<?php

namespace HubletoApp\Community\Settings\Models;

use \ADIOS\Core\Db\Column\Varchar;
use \ADIOS\Core\Db\Column\Color;
use \ADIOS\Core\Db\Column\Boolean;

class ActivityType extends \HubletoMain\Core\Model
{
  public string $table = 'activity_types';
  public string $eloquentClass = Eloquent\ActivityType::class;
  public ?string $lookupSqlValue = '{%TABLE%}.name';

  public function columns(array $columns = []): array
  {
    return parent::columns([
      'name' => (new Varchar($this, $this->translate('Type'))),
      'color' => (new Color($this, $this->translate('Color'))),
      'calendar_visibility' => (new Boolean($this, $this->translate('Show in calendar'))),
      'icon' => (new Varchar($this, $this->translate('TIconype'))),
    ]);
  }

  public function describeTable(): \ADIOS\Core\Description\Table
  {
    $description = parent::describeTable();

    $description->ui['title'] = 'Activity Types';
    $description->ui['addButtonText'] = 'Add Activity Type';
    $description->ui['showHeader'] = true;
    $description->ui['showFooter'] = false;

    return $description;
  }

}
