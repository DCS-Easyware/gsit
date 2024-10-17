<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Fico7489\Laravel\Pivot\Traits\PivotEventTrait;

class Authssooption extends Common
{
  protected $titles = ['SSO option', 'SSO options'];
  protected $icon = 'id card alternate';

  protected $appends = [
  ];

  protected $visible = [
  ];

  protected $with = [
  ];
}
