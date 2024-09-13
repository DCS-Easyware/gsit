<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NetworkEquipmentType extends Common
{
  protected $table = 'glpi_networkequipmenttypes';
  protected $definition = '\App\Models\Definitions\NetworkEquipmentType';
  protected $titles = ['Networking equipment type', 'Networking equipment types'];
  protected $icon = 'edit';

}
