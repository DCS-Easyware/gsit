<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wifinetwork extends Common
{
  protected $definition = '\App\Models\Definitions\Wifinetwork';
  protected $titles = ['Wifi network', 'Wifi networks'];
  protected $icon = 'edit';
}
