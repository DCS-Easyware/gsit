<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TicketTemplate extends Common
{
  protected $table = 'glpi_tickettemplates';
  protected $definition = '\App\Models\Definitions\TicketTemplate';

}
