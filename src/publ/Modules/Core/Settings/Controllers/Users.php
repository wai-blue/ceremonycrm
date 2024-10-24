<?php

namespace CeremonyCrmApp\Modules\Core\Settings\Controllers;

class Users extends \CeremonyCrmApp\Core\Controller {
  public function getBreadcrumbs(): array
  {
    return array_merge(parent::getBreadcrumbs(), [
      [ 'url' => 'settings', 'content' => $this->app->translate('Settings') ],
      [ 'url' => 'users', 'content' => $this->app->translate('Users') ],
    ]);
  }
 }