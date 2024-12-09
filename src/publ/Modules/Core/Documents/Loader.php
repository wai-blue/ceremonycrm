<?php

namespace CeremonyCrmApp\Modules\Core\Documents;

class Loader extends \CeremonyCrmApp\Core\Module
{

  public string $translationContext = 'mod.core.documents.loader';

  public function __construct(\CeremonyCrmApp $app)
  {
    parent::__construct($app);

    $this->registerModel(Models\Document::class);
  }

  public function init(): void
  {
    $this->app->router->httpGet([
      '/^documents\/?$/' => Controllers\Documents::class,
    ]);

    $this->app->sidebar->addLink(1, 70100, 'documents', $this->translate('Documents'), 'fa-regular fa-file');
  }

  public function installTables()
  {
    $mDocuments = new \CeremonyCrmApp\Modules\Core\Documents\Models\Document($this->app);
    $mDocuments->dropTableIfExists()->install();
  }

}