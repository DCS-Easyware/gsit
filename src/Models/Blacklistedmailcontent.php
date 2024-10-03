<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blacklistedmailcontent extends Common
{
  protected $definition = '\App\Models\Definitions\Blacklistedmailcontent';
  protected $titles = ['Blacklisted mail content', 'Blacklisted mail content'];
  protected $icon = 'edit';
}
