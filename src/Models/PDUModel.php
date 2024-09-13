<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PDUModel extends Common
{
  protected $table = 'glpi_pdumodels';
  protected $definition = '\App\Models\Definitions\PDUModel';
  protected $titles = ['PDU model', 'PDU models'];
  protected $icon = 'edit';

}
