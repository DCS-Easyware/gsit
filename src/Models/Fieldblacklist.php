<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fieldblacklist extends Common
{
  protected $table = 'glpi_fieldblacklists';
  protected $definition = '\App\Models\Definitions\Fieldblacklist';
  protected $titles = ['Ignored value for the unicity', 'Ignored values for the unicity'];
  protected $icon = 'edit';

}
