<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RequestType extends Common
{
  protected $table = 'glpi_requesttypes';
  protected $definition = '\App\Models\Definitions\RequestType';
  protected $titles = ['Request source', 'Request sources'];
  protected $icon = 'edit';

}
