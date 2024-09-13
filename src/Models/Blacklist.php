<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blacklist extends Common
{
  protected $table = 'glpi_blacklists';
  protected $definition = '\App\Models\Definitions\Blacklist';
  protected $titles = ['Blacklist', 'Blacklists'];
  protected $icon = 'edit';

}
