<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PhonePowerSupply extends Common
{
  protected $table = 'glpi_phonepowersupplies';
  protected $definition = '\App\Models\Definitions\PhonePowerSupply';
  protected $titles = ['Phone power supply type', 'Phone power supply types'];
  protected $icon = 'edit';

}
