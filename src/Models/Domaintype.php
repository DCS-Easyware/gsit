<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Domaintype extends Common
{
  protected $definition = '\App\Models\Definitions\Domaintype';
  protected $titles = ['Domain type', 'Domain types'];
  protected $icon = 'edit';
}
