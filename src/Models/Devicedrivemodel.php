<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Devicedrivemodel extends Common
{
  protected $definition = '\App\Models\Definitions\Devicedrivemodel';
  protected $titles = ['Device drive model', 'Device drive models'];
  protected $icon = 'edit';
}
