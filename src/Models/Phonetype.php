<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Phonetype extends Common
{
  protected $definition = '\App\Models\Definitions\Phonetype';
  protected $titles = ['Phone type', 'Phone types'];
  protected $icon = 'edit';
}
