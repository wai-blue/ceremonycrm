<?php

namespace CeremonyCrmApp\Modules\Core\Extensions;

class Loader extends \CeremonyCrmApp\Core\Module
{

  public function __construct(\CeremonyCrmApp $app)
  {
    parent::__construct($app);
  }

  public function init(): void
  {
    $this->app->router->httpGet([
      '/^extensions\/?$/' => Controllers\Dashboard::class,
    ]);

    // $router([
    //   '/^extensions$/' => [
    //     'controller' => 'CeremonyCrmApp/Modules/Core/Extensions/Controllers/Dashboard',
    //     'view' => '@app/Modules/Core/Extensions/Views/Dashboard',
    //   ]
    // ]);
  }

  public function modifySidebar(\CeremonyCrmApp\Core\Sidebar $sidebar)
  {
    $sidebar->addLink(1, 999999, 'extensions', $this->app->translate('Extensions'), 'fas fa-puzzle-piece');
  }

}