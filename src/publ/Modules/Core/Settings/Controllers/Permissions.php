<?php

namespace CeremonyCrmApp\Modules\Core\Settings\Controllers;

class Permissions extends \CeremonyCrmApp\Core\Controller {
  public function getBreadcrumbs(): array
  {
    return array_merge(parent::getBreadcrumbs(), [
      [ 'url' => 'settings', 'content' => $this->app->translate('Settings') ],
      [ 'url' => 'permissions', 'content' => $this->app->translate('Permissions') ],
    ]);
  }

 }