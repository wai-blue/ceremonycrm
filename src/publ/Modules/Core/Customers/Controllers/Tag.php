<?php

namespace CeremonyCrmApp\Modules\Core\Customers\Controllers;

class Tag extends \CeremonyCrmApp\Core\Controller {
  public function getBreadcrumbs(): array
  {
    return array_merge(parent::getBreadcrumbs(), [
      [ 'url' => 'customers', 'content' => $this->app->translate('Customers') ],
      [ 'url' => 'tags', 'content' => $this->app->translate('Tags') ],
    ]);
  }

 }