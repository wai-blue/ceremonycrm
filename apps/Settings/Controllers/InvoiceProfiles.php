<?php

namespace HubletoApp\Settings\Controllers;

class InvoiceProfiles extends \HubletoCore\Core\Controller {


  public function getBreadcrumbs(): array
  {
    return array_merge(parent::getBreadcrumbs(), [
      [ 'url' => 'settings', 'content' => $this->translate('Settings') ],
      [ 'url' => 'invoice-profiles', 'content' => $this->translate('Invoice profiles') ],
    ]);
  }

  public function prepareView(): void
  {
    parent::prepareView();
    $this->setView('@app/Settings/Views/InvoiceProfiles.twig');
  }

}