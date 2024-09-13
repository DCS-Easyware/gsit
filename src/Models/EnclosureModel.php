<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EnclosureModel extends Common
{
  protected $table = 'glpi_enclosuremodels';
  protected $definition = '\App\Models\Definitions\EnclosureModel';
  protected $titles = ['Enclosure model', 'Enclosure models'];
  protected $icon = 'edit';

}
