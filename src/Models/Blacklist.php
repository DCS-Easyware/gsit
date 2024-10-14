<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blacklist extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Blacklist';
  protected $titles = ['Blacklist', 'Blacklists'];
  protected $icon = 'edit';
}
