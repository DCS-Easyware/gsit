<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Networkequipmentmodel extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Networkequipmentmodel';
  protected $titles = ['Networking equipment model', 'Networking equipment models'];
  protected $icon = 'edit';
}
