<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlanningEventCategory extends Common
{
  protected $table = 'glpi_planningeventcategories';
  protected $definition = '\App\Models\Definitions\PlanningEventCategory';
  protected $titles = ['Event category', 'Event categories'];
  protected $icon = 'edit';

}
