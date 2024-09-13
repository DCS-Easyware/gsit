<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContractType extends Common
{
  protected $table = 'glpi_contracttypes';
  protected $definition = '\App\Models\Definitions\ContractType';
  protected $titles = ['Contract type', 'Contract types'];
  protected $icon = 'edit';

}
