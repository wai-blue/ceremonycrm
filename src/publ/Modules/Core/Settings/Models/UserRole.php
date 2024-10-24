<?php

namespace CeremonyCrmApp\Modules\Core\Settings\Models;

class UserRole extends \CeremonyCrmApp\Core\Model
{
  const ROLE_ADMINISTRATOR = 1;

  const USER_ROLES = [
    self::ROLE_ADMINISTRATOR => 'ADMINISTRATOR',
  ];

  public string $table = 'user_roles';
  public string $eloquentClass = Eloquent\UserRole::class;
  public ?string $lookupSqlValue = '{%TABLE%}.role';

  public array $relations = [
    'PERMISSIONS' => [ self::HAS_MANY, RolePermission::class, 'id_role', 'id'],
  ];

  public function columns(array $columns = []): array
  {
    return parent::columns([
      'role' => [
        'type' => 'varchar',
        'title' => $this->translate('Role')
      ],
    ]);
  }

  public function tableDescribe(array $description = []): array
  {
    $description = parent::tableDescribe();
    $description['ui']['title'] = 'User Roles';
    $description['ui']['addButtonText'] = 'Add User Role';
    $description['ui']['showHeader'] = true;
    $description['ui']['showFooter'] = false;
    return $description;
  }

  public function formDescribe(array $description = []): array
  {
    $description = parent::formDescribe();
    $description['includeRelations'] = ['PERMISSIONS'];
    return $description;
  }
}