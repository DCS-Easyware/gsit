<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OperatingSystemServicePack extends Common
{
  protected $table = 'glpi_operatingsystemservicepacks';
  protected $definition = '\App\Models\Definitions\OperatingSystemServicePack';
  protected $titles = ['Service pack', 'Service packs'];
  protected $icon = 'edit';

}
