<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Domainrelation extends Common
{
  protected $definition = '\App\Models\Definitions\Domainrelation';
  protected $titles = ['Domain relation', 'Domains relations'];
  protected $icon = 'edit';
}
