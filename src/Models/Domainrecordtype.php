<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Domainrecordtype extends Common
{
  protected $definition = '\App\Models\Definitions\Domainrecordtype';
  protected $titles = ['Record type', 'Records types'];
  protected $icon = 'edit';
}
