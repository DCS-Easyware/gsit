<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DomainRecordType extends Common
{
  protected $table = 'glpi_domainrecordtypes';
  protected $definition = '\App\Models\Definitions\DomainRecordType';
  protected $titles = ['Record type', 'Records types'];
  protected $icon = 'edit';

}
