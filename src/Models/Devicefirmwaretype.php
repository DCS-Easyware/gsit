<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Devicefirmwaretype extends Common
{
  protected $definition = '\App\Models\Definitions\Devicefirmwaretype';
  protected $titles = ['Firmware type', 'Firmware types'];
  protected $icon = 'edit';
}
