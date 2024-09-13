<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VirtualMachineState extends Common
{
  protected $table = 'glpi_virtualmachinestates';
  protected $definition = '\App\Models\Definitions\VirtualMachineState';
  protected $titles = ['State of the virtual machine', 'States of the virtual machine'];
  protected $icon = 'edit';

}
