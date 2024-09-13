<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Calendar extends Common
{
  protected $table = 'glpi_calendars';
  protected $definition = '\App\Models\Definitions\Calendar';
  protected $titles = ['Calendar', 'Calendars'];
  protected $icon = 'edit';

}
