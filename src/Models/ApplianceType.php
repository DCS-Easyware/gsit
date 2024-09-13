<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApplianceType extends Common
{
  protected $table = 'glpi_appliancetypes';
  protected $definition = '\App\Models\Definitions\ApplianceType';
  protected $titles = ['Appliance type', 'Appliance types'];
  protected $icon = 'edit';

}
