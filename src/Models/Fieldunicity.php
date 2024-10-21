<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fieldunicity extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Fieldunicity';
  protected $titles = ['Fields unicity', 'Fields unicity'];
  protected $icon = 'edit';
}
