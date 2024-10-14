<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ssovariable extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Ssovariable';
  protected $titles = [
    'Field storage of the login in the HTTP request',
    'Fields storage of the login in the HTTP request'
  ];
  protected $icon = 'edit';
}
