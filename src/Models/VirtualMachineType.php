<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VirtualMachineType extends Common
{
  protected $table = 'glpi_virtualmachinetypes';
  protected $definition = '\App\Models\Definitions\VirtualMachineType';
  protected $titles = ['Virtualization system', 'Virtualization systems'];
  protected $icon = 'edit';

}
