<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Network extends Common
{
  protected $definition = '\App\Models\Definitions\Network';
  protected $titles = ['Network', 'Networks'];
  protected $icon = 'edit';
}
