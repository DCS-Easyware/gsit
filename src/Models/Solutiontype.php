<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Solutiontype extends Common
{
  protected $definition = '\App\Models\Definitions\Solutiontype';
  protected $titles = ['Solution type', 'Solution types'];
  protected $icon = 'edit';
}
