<?php

namespace CeremonyCrmMod\Pipeline\Controllers;

use CeremonyCrmMod\Settings\Models\Tag;
use CeremonyCrmMod\Settings\Models\Pipeline;
use CeremonyCrmMod\Settings\Models\Setting;
use CeremonyCrmMod\Deals\Models\Deal;

class Home extends \CeremonyCrmApp\Core\Controller {


  public function getBreadcrumbs(): array
  {
    return array_merge(parent::getBreadcrumbs(), [
      [ 'url' => '', 'content' => $this->translate('Sales') ],
    ]);
  }

  public function prepareView(): void
  {
    parent::prepareView();

    $mSetting = new Setting($this->app);
    $mPipeline = new Pipeline($this->app);
    $mDeal = new Deal($this->app);
    $mTag = new Tag($this->app);
    $sumPipelinePrice = 0;

    $pipelines = $mPipeline->eloquent->get();

    $defaultPipelineId = $mSetting->eloquent
      ->select("value")
      ->where("key", "Modules\Core\Settings\Pipeline\DefaultPipeline")
      ->first()
      ->toArray()
    ;
    $defaultPipelineId = reset($defaultPipelineId);

    $searchPipeline = null;

    if (isset($this->app->params["id_pipeline"])){
      $searchPipeline = $mPipeline->eloquent
        ->where("id", (int) $this->app->params["id_pipeline"])
        ->with("PIPELINE_STEPS")
        ->first()
        ->toArray()
      ;
    }
    else {
      $searchPipeline = $mPipeline->eloquent
        ->where("id", (int) $defaultPipelineId)
        ->with("PIPELINE_STEPS")
        ->first()
        ->toArray()
      ;
    }

    foreach ($searchPipeline["PIPELINE_STEPS"] as $key => $step) {
      $sumPrice = $mDeal->eloquent
        ->selectRaw("SUM(price) as price")
        ->where("id_pipeline", $searchPipeline["id"])
        ->where("id_pipeline_step", $step["id"])
        ->first()
        ->price
      ;
      $currencyGroups = $mDeal->eloquent
        ->selectRaw("SUM(price) as price, currencies.code")
        ->where("id_pipeline", $searchPipeline["id"])
        ->where("id_pipeline_step", $step["id"])
        ->groupBy("id_currency")
        ->join("currencies", "currencies.id", "=", "deals.id_currency")
        ->get()
        ->toArray();
      ;

      $searchPipeline["PIPELINE_STEPS"][$key]["sum_price"] = $sumPrice;
      $searchPipeline["PIPELINE_STEPS"][$key]["currency_groups"] = $currencyGroups;
      $sumPipelinePrice += $sumPrice;
    }

    $searchPipeline["price"] = $sumPipelinePrice;

    $currencyGroups = $mDeal->eloquent
      ->selectRaw("SUM(price) as price, currencies.code")
      ->where("id_pipeline", $searchPipeline["id"])
      ->groupBy("id_currency")
      ->join("currencies", "currencies.id", "=", "deals.id_currency")
      ->get()
      ->toArray();
    ;

    $deals = $mDeal->eloquent
      ->where("id_pipeline", (int) $searchPipeline["id"])
      ->with("CURRENCY")
      ->with("COMPANY")
      ->with("TAGS")
      ->get()
      ->toArray()
    ;

    foreach ($deals as $key => $deal) {
      $tag = $mTag->eloquent->find($deal["TAGS"][0]["id_tag"])?->toArray();
      $deals[$key]["TAG"] = $tag;
      unset($deals[$key]["TAGS"]);
    }

    //var_dump($deals); exit;
    $this->viewParams["pipelines"] = $pipelines;
    $this->viewParams["pipeline"] = $searchPipeline;
    $this->viewParams["pipeline"]["currency_groups"] = $currencyGroups;
    $this->viewParams["deals"] = $deals;

    $this->setView('@mod/Pipeline/Views/Home.twig');
  }

}