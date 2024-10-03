<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Applianceenvironment extends Common
{
  protected $definition = '\App\Models\Definitions\Applianceenvironment';
  protected $titles = ['Appliance environment', 'Appliance environments'];
  protected $icon = 'edit';
}
