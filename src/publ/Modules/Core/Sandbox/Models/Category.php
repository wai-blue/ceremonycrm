<?php

namespace CeremonyCrmApp\Modules\Core\Sandbox\Models;

class Category extends \CeremonyCrmApp\Core\Model
{
  public string $table = 'sbx_categories';
  public string $eloquentClass = Eloquent\Category::class;
  public ?string $lookupSqlValue = "{%TABLE%}.category";

  public function columns(array $columns = []): array
  {
    return parent::columns(array_merge($columns, [
      "category" => [
        "type" => "varchar",
        "title" => "Category",
      ],
      "color" => [
        "type" => "color",
        "title" => "Color",
      ],
    ]));
  }

  public function tableDescribe(array $description = []): array
  {
    $description = parent::tableDescribe();
    $description['title'] = 'Categories';
    return $description;
  }

}
