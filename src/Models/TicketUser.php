<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TicketUser extends Common
{
  protected $table = 'glpi_tickets_users';
  // protected $titles = ['Ticket', 'Tickets'];
  // protected $icon = 'hands helping';
}
