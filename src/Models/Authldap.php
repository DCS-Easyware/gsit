<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Fico7489\Laravel\Pivot\Traits\PivotEventTrait;

class Authldap extends Common
{
  protected $definition = '\App\Models\Definitions\Authldap';
  protected $titles = ['LDAP', 'LDAP'];
  protected $icon = 'address book outline';

  protected $appends = [
  ];

  protected $visible = [
  ];

  protected $with = [
  ];
}
