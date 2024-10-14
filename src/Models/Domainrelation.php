<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Domainrelation extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Domainrelation';
  protected $titles = ['Domain relation', 'Domains relations'];
  protected $icon = 'edit';
}
