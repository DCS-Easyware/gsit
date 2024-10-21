<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vlan extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Vlan';
  protected $titles = ['VLAN', 'VLANs'];
  protected $icon = 'edit';
}
