<?php

namespace CeremonyCrmApp\Modules\Core\Settings\Controllers;

class DealStatuses extends \CeremonyCrmApp\Core\Controller {

  public string $translationContext = 'mod.core.settings.controllers.dealStatuses';

  public function getBreadcrumbs(): array
  {
    return array_merge(parent::getBreadcrumbs(), [
      [ 'url' => 'settings', 'content' => $this->translate('Settings') ],
      [ 'url' => 'lead-statuses', 'content' => $this->translate('Deal Statuses') ],
    ]);
  }

}