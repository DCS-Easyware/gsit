<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blacklistedmailcontent extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Blacklistedmailcontent';
  protected $titles = ['Blacklisted mail content', 'Blacklisted mail content'];
  protected $icon = 'edit';
}
