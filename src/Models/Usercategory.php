<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usercategory extends Common
{
  protected $definition = '\App\Models\Definitions\Usercategory';
  protected $titles = ['User category', 'User categories'];
  protected $icon = 'edit';
}
