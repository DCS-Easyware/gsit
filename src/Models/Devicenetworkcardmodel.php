<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Devicenetworkcardmodel extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Devicenetworkcardmodel';
  protected $titles = ['Network card model', 'Network card models'];
  protected $icon = 'edit';
}
