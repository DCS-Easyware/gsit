<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificatetype extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Certificatetype';
  protected $titles = ['Certificate type', 'Certificate types'];
  protected $icon = 'edit';
}
