<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clustertype extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Clustertype';
  protected $titles = ['Cluster type', 'Cluster types'];
  protected $icon = 'edit';
}
