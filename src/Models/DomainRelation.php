<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DomainRelation extends Common
{
  protected $table = 'glpi_domainrelations';
  protected $definition = '\App\Models\Definitions\DomainRelation';
  protected $titles = ['Domain relation', 'Domains relations'];
  protected $icon = 'edit';

}
