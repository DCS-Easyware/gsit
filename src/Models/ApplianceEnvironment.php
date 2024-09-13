<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApplianceEnvironment extends Common
{
  protected $table = 'glpi_applianceenvironments';
  protected $definition = '\App\Models\Definitions\ApplianceEnvironment';
  protected $titles = ['Appliance environment', 'Appliance environments'];
  protected $icon = 'edit';

}
