<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Deviceharddrivemodel extends Common
{
  protected $definition = '\App\Models\Definitions\Deviceharddrivemodel';
  protected $titles = ['Device hard drive model', 'Device hard drive models'];
  protected $icon = 'edit';
}
