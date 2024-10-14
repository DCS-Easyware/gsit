<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usercategory extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Usercategory';
  protected $titles = ['User category', 'User categories'];
  protected $icon = 'edit';
}
