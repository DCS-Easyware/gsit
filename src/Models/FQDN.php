<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FQDN extends Common
{
  protected $table = 'glpi_fqdns';
  protected $definition = '\App\Models\Definitions\FQDN';
  protected $titles = ['Internet domain', 'Internet domains'];
  protected $icon = 'edit';

}
