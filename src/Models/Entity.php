<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entity extends Common
{
  protected $table = 'glpi_entities';
  protected $definition = '\App\Models\Definitions\Entity';
  protected $titles = ['Entity', 'Entities'];
  protected $icon = 'layer group';

}
