<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mailcollector extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Mailcollector';
  protected $titles = ['Receiver', 'Receivers'];
  protected $icon = 'edit';
}
