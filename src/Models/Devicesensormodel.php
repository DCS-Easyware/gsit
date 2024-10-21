<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Devicesensormodel extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Devicesensormodel';
  protected $titles = ['Device sensor model', 'Device sensor models'];
  protected $icon = 'edit';
}
