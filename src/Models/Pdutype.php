<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pdutype extends Common
{
  protected $definition = '\App\Models\Definitions\Pdutype';
  protected $titles = ['PDU type', 'PDU types'];
  protected $icon = 'edit';
}
