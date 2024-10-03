<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pdumodel extends Common
{
  protected $definition = '\App\Models\Definitions\Pdumodel';
  protected $titles = ['PDU model', 'PDU models'];
  protected $icon = 'edit';
}
