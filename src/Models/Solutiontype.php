<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solutiontype extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Solutiontype';
  protected $titles = ['Solution type', 'Solution types'];
  protected $icon = 'edit';
}
