<?php

namespace HubletoApp\Community\Settings\Models\Eloquent;

use \Illuminate\Database\Eloquent\Relations\HasMany;

class Pipeline extends \HubletoMain\Core\ModelEloquent
{
  public $table = 'pipelines';

  public function PIPELINE_STEPS(): HasMany //@phpstan-ignore-line
  {
    return $this->hasMany(PipelineStep::class, 'id_pipeline', 'id')->orderBy('order', 'asc'); //@phpstan-ignore-line
  }
}
