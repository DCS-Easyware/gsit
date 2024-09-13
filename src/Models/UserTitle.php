<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserTitle extends Common
{
  protected $table = 'glpi_usertitles';
  protected $definition = '\App\Models\Definitions\UserTitle';
  protected $titles = ['User title', 'Users titles'];
  protected $icon = 'edit';

}
