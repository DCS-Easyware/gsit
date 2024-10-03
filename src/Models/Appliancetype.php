<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appliancetype extends Common
{
  protected $definition = '\App\Models\Definitions\Appliancetype';
  protected $titles = ['Appliance type', 'Appliance types'];
  protected $icon = 'edit';
}
