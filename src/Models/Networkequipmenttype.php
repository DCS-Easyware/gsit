<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Networkequipmenttype extends Common
{
  protected $definition = '\App\Models\Definitions\Networkequipmenttype';
  protected $titles = ['Networking equipment type', 'Networking equipment types'];
  protected $icon = 'edit';
}
