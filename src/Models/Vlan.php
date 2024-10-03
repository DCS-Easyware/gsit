<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vlan extends Common
{
  protected $definition = '\App\Models\Definitions\Vlan';
  protected $titles = ['VLAN', 'VLANs'];
  protected $icon = 'edit';
}
