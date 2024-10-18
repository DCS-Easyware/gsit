<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suppliertype extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Suppliertype';
  protected $titles = ['Third party type', 'Third party types'];
  protected $icon = 'edit';
}
