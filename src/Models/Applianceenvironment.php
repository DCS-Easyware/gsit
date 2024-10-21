<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Applianceenvironment extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Applianceenvironment';
  protected $titles = ['Appliance environment', 'Appliance environments'];
  protected $icon = 'edit';
}
