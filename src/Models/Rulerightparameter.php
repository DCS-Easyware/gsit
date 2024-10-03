<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rulerightparameter extends Common
{
  protected $definition = '\App\Models\Definitions\Rulerightparameter';
  protected $titles = ['LDAP criterion', 'LDAP criteria'];
  protected $icon = 'edit';
}
