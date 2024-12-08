<?php

namespace CeremonyCrmApp\Core;

class Module {
  public \CeremonyCrmApp $app;
  protected array $registeredModels = [];

  public function __construct(\CeremonyCrmApp $app)
  {
    $this->app = $app;
  }

  public function init(): void
  {
  }

  public function registerModel(string $model)
  {
    if (!in_array($model, $this->registeredModels)) {
      $this->registeredModels[] = $model;
    }
  }

  public function getRegisteredModels(): array
  {
    return $this->registeredModels;
  }

  public function modifySidebar(\CeremonyCrmApp\Core\Sidebar $sidebar)
  {
    // to be overriden
  }

  public function installTables()
  {
    // to be overriden
  }

  public function installDefaultPermissions()
  {
    // to be overriden
  }
}