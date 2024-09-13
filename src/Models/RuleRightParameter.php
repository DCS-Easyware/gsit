<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RuleRightParameter extends Common
{
  protected $table = 'glpi_rulerightparameters';
  protected $definition = '\App\Models\Definitions\RuleRightParameter';
  protected $titles = ['LDAP criterion', 'LDAP criteria'];
  protected $icon = 'edit';

}
