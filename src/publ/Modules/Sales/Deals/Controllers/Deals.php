<?php

namespace CeremonyCrmApp\Modules\Sales\Deals\Controllers;

class Deals extends \CeremonyCrmApp\Core\Controller {
  public function getBreadcrumbs(): array
  {
    return array_merge(parent::getBreadcrumbs(), [
      [ 'url' => 'sales', 'content' => $this->app->translate('Sales') ],
      [ 'url' => '', 'content' => $this->app->translate('Deals') ],
    ]);
  }

  public function prepareView(): void
  {
    parent::prepareView();
    $this->setView('@app/Modules/Sales/Deals/Views/Deals.twig');
  }

}