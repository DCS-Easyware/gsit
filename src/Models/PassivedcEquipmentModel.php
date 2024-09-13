<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PassivedcEquipmentModel extends Common
{
  protected $table = 'glpi_passivedcequipmentmodels';
  protected $definition = '\App\Models\Definitions\PassivedcEquipmentModel';
  protected $titles = ['Passive device model', 'Passive device models'];
  protected $icon = 'edit';

}
