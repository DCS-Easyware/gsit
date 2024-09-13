<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PDUType extends Common
{
  protected $table = 'glpi_pdutypes';
  protected $definition = '\App\Models\Definitions\PDUType';
  protected $titles = ['PDU type', 'PDU types'];
  protected $icon = 'edit';

}
