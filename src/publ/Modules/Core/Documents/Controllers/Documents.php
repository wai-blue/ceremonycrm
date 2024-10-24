<?php

namespace CeremonyCrmApp\Modules\Core\Documents\Controllers;

class Documents extends \CeremonyCrmApp\Core\Controller {
  public function getBreadcrumbs(): array
  {
    return array_merge(parent::getBreadcrumbs(), [
      [ 'url' => 'documents', 'content' => $this->app->translate('Documents') ],
    ]);
  }

 }