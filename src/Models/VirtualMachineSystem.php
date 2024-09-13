<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VirtualMachineSystem extends Common
{
  protected $table = 'glpi_virtualmachinesystems';
  protected $definition = '\App\Models\Definitions\VirtualMachineSystem';
  protected $titles = ['Virtualization model', 'Virtualization models'];
  protected $icon = 'edit';

}
