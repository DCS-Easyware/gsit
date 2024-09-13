<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BudgetType extends Common
{
  protected $table = 'glpi_budgettypes';
  protected $definition = '\App\Models\Definitions\BudgetType';
  protected $titles = ['Budget type', 'Budget types'];
  protected $icon = 'edit';

}
