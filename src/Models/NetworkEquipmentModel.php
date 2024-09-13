<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NetworkEquipmentModel extends Common
{
  protected $table = 'glpi_networkequipmentmodels';
  protected $definition = '\App\Models\Definitions\NetworkEquipmentModel';
  protected $titles = ['Networking equipment model', 'Networking equipment models'];
  protected $icon = 'edit';

}
