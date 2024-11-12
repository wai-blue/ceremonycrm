<?php

namespace CeremonyCrmApp\Modules\Sales\Sales\Controllers;

use CeremonyCrmApp\Modules\Core\Settings\Models\Pipeline;
use CeremonyCrmApp\Modules\Core\Settings\Models\PipelineStep;
use Exception;

class ChangePipeline extends \CeremonyCrmApp\Core\Controller
{

  public function renderJson(): ?array
  {
    $mPipeline = new Pipeline($this->app);
    $mPipelineStep = new PipelineStep($this->app);
    $newPipeline = null;

    try {
      $newPipeline = $mPipeline->eloquent
        ->where("id", $this->params["idPipeline"])
        ->with("PIPELINE_STEPS")
        ->first()
        ->toArray()
      ;
    } catch (Exception $e) {
      return [
        "status" => "failed",
        "error" => $e
      ];
    }

    return [
      "newPipeline" => $newPipeline,
      "status" => "success"
    ];
  }
}