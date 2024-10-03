<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clustertype extends Common
{
  protected $definition = '\App\Models\Definitions\Clustertype';
  protected $titles = ['Cluster type', 'Cluster types'];
  protected $icon = 'edit';
}
