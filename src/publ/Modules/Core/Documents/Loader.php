<?php

namespace CeremonyCrmApp\Modules\Core\Documents;

class Loader extends \CeremonyCrmApp\Core\Module
{

  public function __construct(\CeremonyCrmApp $app)
  {
    parent::__construct($app);

    $this->registerModel(Models\Document::class);
  }

  public function addRouting(\CeremonyCrmApp\Core\Router $router)
  {
    $router->addRoutingGroup(
      'documents',
      'CeremonyCrmApp/Modules/Core/Documents/Controllers',
      'CeremonyCrmApp/Modules/Core/Documents/Views',
      [
        'idAccount' => '$1',
      ],
      [
        '' => 'Documents',
      ]
    );

  }

  public function modifySidebar(\CeremonyCrmApp\Core\Sidebar $sidebar)
  {
    $sidebar->addLink(1, 70100, 'documents', $this->app->translate('Documents'), 'fa-regular fa-file');
  }

  public function generateTestData()
  {
    $mCompany = new Models\Document($this->app);
    $mCompany->install();
  }
}