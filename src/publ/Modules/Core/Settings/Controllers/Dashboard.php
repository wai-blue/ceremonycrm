<?php

namespace CeremonyCrmApp\Modules\Core\Settings\Controllers;

class Dashboard extends \CeremonyCrmApp\Core\Controller {

  public function prepareView(): void
  {
    parent::prepareView();
    $this->setView('@app/Modules/Core/Settings/Views/Dashboard.twig');
  }

}