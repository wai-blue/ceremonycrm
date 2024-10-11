<?php

namespace CeremonyCrmApp\Modules\Core\Settings\Controllers;

class Labels extends \CeremonyCrmApp\Core\Controller {
  public function getBreadcrumbs(): array
  {
    return array_merge(parent::getBreadcrumbs(), [
      [ 'url' => 'settings', 'content' => $this->app->translate('Settings') ],
      [ 'url' => 'labels', 'content' => $this->app->translate('Labels') ],
    ]);
  }

 }