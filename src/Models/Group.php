<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Common
{
  protected $table = 'glpi_groups';
  protected $definition = '\App\Models\Definitions\Group';
  protected $titles = ['Group', 'Groups'];
  protected $icon = 'users';

}
