<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NetworkInterface extends Common
{
  protected $table = 'glpi_networkinterfaces';
  protected $definition = '\App\Models\Definitions\NetworkInterface';
  protected $titles = ['Network interface', 'Network interfaces'];
  protected $icon = 'edit';

}
