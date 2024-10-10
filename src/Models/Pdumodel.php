<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pdumodel extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Pdumodel';
  protected $titles = ['PDU model', 'PDU models'];
  protected $icon = 'edit';
}
