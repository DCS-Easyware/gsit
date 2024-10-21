<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wifinetwork extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Wifinetwork';
  protected $titles = ['Wifi network', 'Wifi networks'];
  protected $icon = 'edit';
}
