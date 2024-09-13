<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IPNetwork extends Common
{
  protected $table = 'glpi_ipnetworks';
  protected $definition = '\App\Models\Definitions\IPNetwork';
  protected $titles = ['IP network', 'IP networks'];
  protected $icon = 'edit';

}
