<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WifiNetwork extends Common
{
  protected $table = 'glpi_wifinetworks';
  protected $definition = '\App\Models\Definitions\WifiNetwork';
  protected $titles = ['Wifi network', 'Wifi networks'];
  protected $icon = 'edit';

}
