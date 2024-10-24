<?php

namespace CeremonyCrmApp\Modules\Sales\Sales\Controllers;

use CeremonyCrmApp\Modules\Core\Settings\Models\Setting;
use CeremonyCrmApp\Modules\Sales\Sales\Models\Deal;
use CeremonyCrmApp\Modules\Sales\Sales\Models\DealHistory;
use CeremonyCrmApp\Modules\Sales\Sales\Models\Lead;
use CeremonyCrmApp\Modules\Sales\Sales\Models\LeadHistory;
use Exception;

class ConvertLead extends \CeremonyCrmApp\Core\Controller
{

  public function renderJson(): ?array
  {
    $leadId = $this->params["recordId"];
    $mLead = new Lead($this->app);
    $mLeadHistory = new LeadHistory($this->app);
    $mDeal = new Deal($this->app);
    $mDealHistory = new DealHistory($this->app);
    $deal = null;

    $mSettings = new Setting($this->app);
    $defaultPipeline =(int) $mSettings->eloquent
      ->where("key", "Modules\Core\Settings\Pipeline\DefaultPipeline")
      ->first()
      ->value
    ;

    try {
      $lead = $mLead->eloquent->where("id", $leadId)->first();

      $deal = $mDeal->eloquent->create([
        "title" => $lead->title,
        "id_company" => $lead->id_company,
        "id_person" => $lead->id_person,
        "price" => $lead->price,
        "id_currency" => $lead->id_currency,
        "date_expected_close" => $lead->date_expected_close,
        "id_user" => $lead->id_user,
        "source_channel" => $lead->source_channel,
        "is_archived" => $lead->is_archived,
        "id_lead" => $lead->id,
        "id_pipeline" => $defaultPipeline,
        "id_pipeline_step" => null
      ]);


      $leadHistories = $mLeadHistory->eloquent->where("id_lead", $leadId)->get();

      foreach ($leadHistories as $leadHistory) {
        $mDealHistory->eloquent->create([
          "description" => $leadHistory->description,
          "change_date" => $leadHistory->change_date,
          "id_deal" => $deal->id
        ]);
      }

      $mLeadHistory->eloquent->create([
        "description" => "Converted to a Deal",
        "change_date" => date("Y-m-d"),
        "id_lead" => $leadId
      ]);

      $mDealHistory->eloquent->create([
        "description" => "Converted to a Deal",
        "change_date" => date("Y-m-d"),
        "id_deal" => $deal->id
      ]);

    } catch (Exception $e) {

      var_dump($e); exit;
      return [
        "status" => "failed",
        "error" => $e
      ];
    }

    return [
      "status" => "success",
      "idDeal" => $deal->id,
      "title" => str_replace(" ", "+", $deal->title)
    ];
  }
}
