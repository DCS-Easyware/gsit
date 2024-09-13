<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DomainType extends Common
{
  protected $table = 'glpi_domaintypes';
  protected $definition = '\App\Models\Definitions\DomainType';
  protected $titles = ['Domain type', 'Domain types'];
  protected $icon = 'edit';

}
