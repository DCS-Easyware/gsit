<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClusterType extends Common
{
  protected $table = 'glpi_clustertypes';
  protected $definition = '\App\Models\Definitions\ClusterType';
  protected $titles = ['Cluster type', 'Cluster types'];
  protected $icon = 'edit';

}
