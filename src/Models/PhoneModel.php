<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PhoneModel extends Common
{
  protected $table = 'glpi_phonemodels';
  protected $definition = '\App\Models\Definitions\PhoneModel';
  protected $titles = ['Phone model', 'Phone models'];
  protected $icon = 'edit';

}
