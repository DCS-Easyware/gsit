<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tickettemplate extends Common
{
  protected $definition = '\App\Models\Definitions\Tickettemplate';
}
