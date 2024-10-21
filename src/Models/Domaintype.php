<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Domaintype extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Domaintype';
  protected $titles = ['Domain type', 'Domain types'];
  protected $icon = 'edit';
}
