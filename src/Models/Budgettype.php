<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Budgettype extends Common
{
  protected $definition = '\App\Models\Definitions\Budgettype';
  protected $titles = ['Budget type', 'Budget types'];
  protected $icon = 'edit';
}
