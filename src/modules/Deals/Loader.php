<?php

namespace CeremonyCrmMod\Deals;

class Loader extends \CeremonyCrmApp\Core\Module
{


  public function __construct(\CeremonyCrmApp $app)
  {
    parent::__construct($app);
  }

  public function init(): void
  {
    $this->app->router->httpGet([
      '/^deals\/?$/' => Controllers\Deals::class,
      '/^deals\/get-calendar-events\/?$/' => Controllers\Api\GetCalendarEvents::class,
      '/^deals\/archive\/?$/' => Controllers\DealsArchive::class,
      '/^deals\/change-pipeline\/?$/' => Controllers\Api\ChangePipeline::class,
      '/^deals\/change-pipeline-step\/?$/' => Controllers\Api\ChangePipelineStep::class,
      '/^settings\/deal-statuses\/?$/' => Controllers\DealStatuses::class,
    ]);

    $this->app->sidebar->addLink(1, 200, 'deals', $this->translate('Deals'), 'fas fa-handshake', str_starts_with($this->app->requestedUri, 'deals'));

    $this->app->addSetting([
      'title' => $this->translate('Deal statuses'),
      'icon' => 'fas fa-arrow-up-short-wide',
      'url' => 'settings/deal-statuses',
    ]);

    $this->app->addCalendar(Calendar::class);
  }

  public function installTables()
  {
    $mDealStatus = new Models\DealStatus($this->app);
    $mDeal = new \CeremonyCrmMod\Deals\Models\Deal($this->app);
    $mDealHistory = new \CeremonyCrmMod\Deals\Models\DealHistory($this->app);
    $mDealTag = new \CeremonyCrmMod\Deals\Models\DealTag($this->app);
    $mDealService = new \CeremonyCrmMod\Deals\Models\DealService($this->app);
    $mDealActivity = new \CeremonyCrmMod\Deals\Models\DealActivity($this->app);
    $mDealDocument = new \CeremonyCrmMod\Deals\Models\DealDocument($this->app);

    $mDealStatus->dropTableIfExists()->install();
    $mDeal->dropTableIfExists()->install();
    $mDealHistory->dropTableIfExists()->install();
    $mDealTag->dropTableIfExists()->install();
    $mDealService->dropTableIfExists()->install();
    $mDealActivity->dropTableIfExists()->install();
    $mDealDocument->dropTableIfExists()->install();

    $mDealStatus->eloquent->create([ 'name' => 'New', 'order' => 1, 'color' => '#f55442' ]);
    $mDealStatus->eloquent->create([ 'name' => 'In Progress', 'order' => 2, 'color' => '#f5bc42' ]);
    $mDealStatus->eloquent->create([ 'name' => 'Closed', 'order' => 3, 'color' => '#42ddf5' ]);
    $mDealStatus->eloquent->create([ 'name' => 'Lost', 'order' => 4, 'color' => '#f55442' ]);

  }
}