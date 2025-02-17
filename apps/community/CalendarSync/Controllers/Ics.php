<?php

namespace HubletoApp\Community\CalendarSync\Controllers;

class Ics extends \HubletoMain\Core\Controller {
  public function prepareView(): void {
    parent::prepareView();
    $this->viewParams['now'] = date('Y-m-d H:i:s');
    $this->setView('@HubletoApp:Community:CalendarSync/ics.twig');

    // $mSource = new Source($this->app);
    // $mSource->install();
  }
}