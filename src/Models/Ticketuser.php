<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticketuser extends Common
{
  use SoftDeletes;

  // protected $titles = ['Ticket', 'Tickets'];
  // protected $icon = 'hands helping';
}
