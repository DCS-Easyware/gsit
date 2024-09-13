<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SsoVariable extends Common
{
  protected $table = 'glpi_ssovariables';
  protected $definition = '\App\Models\Definitions\SsoVariable';
  protected $titles = ['Field storage of the login in the HTTP request', 'Fields storage of the login in the HTTP request'];
  protected $icon = 'edit';

}
