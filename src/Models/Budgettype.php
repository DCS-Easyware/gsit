<?php

namespace App\Models;


class Budgettype extends Common
{
  protected $table = 'glpi_budgettypes';
  protected $definition = '\App\Models\Definitions\BudgetType';

}
