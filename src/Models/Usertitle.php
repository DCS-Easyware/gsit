<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usertitle extends Common
{
  protected $definition = '\App\Models\Definitions\Usertitle';
  protected $titles = ['User title', 'Users titles'];
  protected $icon = 'edit';
}
