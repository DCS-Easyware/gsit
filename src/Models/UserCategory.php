<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserCategory extends Common
{
  protected $table = 'glpi_usercategories';
  protected $definition = '\App\Models\Definitions\UserCategory';
  protected $titles = ['User category', 'User categories'];
  protected $icon = 'edit';

}
