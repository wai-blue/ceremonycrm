<?php

namespace CeremonyCrmApp\Modules\Sales\Core;

class Loader extends \CeremonyCrmApp\Core\Module
{

  public string $translationContext = 'mod.sales.core.loader';

  public function __construct(\CeremonyCrmApp $app)
  {
    parent::__construct($app);
  }

  public function init(): void
  {
    $this->app->router->httpGet([
      '/^sales\/?$/' => Controllers\Home::class,
    ]);

    $this->app->sidebar->addLink(1, 80100, 'sales', $this->translate('Sales'), 'fas fa-money-bill');

    if (str_starts_with($this->app->requestedUri, 'sales')) {
      $this->app->sidebar->addHeading1(2, 10200, $this->translate('Sales'));
      $this->app->sidebar->addLink(2, 10201, 'sales', $this->translate('Pipeline'), 'fas fa-timeline');
    }
  }
}