<?php

namespace CeremonyCrmApp\Modules\Sales\Deals;

class Loader extends \CeremonyCrmApp\Core\Module
{

  public function __construct(\CeremonyCrmApp $app)
  {
    parent::__construct($app);
  }

  public function init(): void
  {
    $this->app->router->httpGet([
      '/^sales\/deals\/?$/' => Controllers\Deals::class,
      '/^sales\/change-pipeline\/?$/' => Controllers\ChangePipeline::class,
      '/^sales\/change-pipeline-step\/?$/' => Controllers\ChangePipelineStep::class,
    ]);

    // $router(
    //   'sales',
    //   'CeremonyCrmApp/Modules/Sales/Sales/Controllers',
    //   '@app/Modules/Sales/Sales/Views',
    //   [
    //     'idAccount' => '$1',
    //   ],
    //   [
    //     '' => 'Home',
    //     '/leads' => 'Leads',
    //     '/deals' => 'Deals',
    //     '/convert-lead' => 'ConvertLead',
    //     '/convert-lead' => 'ConvertLead',
    //     '/change-pipeline' => 'ChangePipeline',
    //     '/change-pipeline-step' => 'ChangePipelineStep',
    //   ]
    // );
  }

  public function modifySidebar(\CeremonyCrmApp\Core\Sidebar $sidebar)
  {
    if (str_starts_with($this->app->requestedUri, 'sales')) {
      $sidebar->addLink(2, 10203, 'sales/deals', $this->app->translate('Deals'), 'fa-regular fa-handshake');
    }
  }

  public function generateTestData()
  {}
}