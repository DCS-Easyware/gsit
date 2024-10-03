<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fieldunicity extends Common
{
  protected $definition = '\App\Models\Definitions\Fieldunicity';
  protected $titles = ['Fields unicity', 'Fields unicity'];
  protected $icon = 'edit';
}
