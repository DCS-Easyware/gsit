<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BlacklistedMailContent extends Common
{
  protected $table = 'glpi_blacklistedmailcontents';
  protected $definition = '\App\Models\Definitions\BlacklistedMailContent';
  protected $titles = ['Blacklisted mail content', 'Blacklisted mail content'];
  protected $icon = 'edit';

}
