<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PassivedcEquipmentType extends Common
{
  protected $table = 'glpi_passivedcequipmenttypes';
  protected $definition = '\App\Models\Definitions\PassivedcEquipmentType';
  protected $titles = ['Passive device type', 'Passive device types'];
  protected $icon = 'edit';

}
