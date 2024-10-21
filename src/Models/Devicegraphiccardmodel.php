<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Devicegraphiccardmodel extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Devicegraphiccardmodel';
  protected $titles = ['Device graphic card model', 'Device graphic card models'];
  protected $icon = 'edit';
}
