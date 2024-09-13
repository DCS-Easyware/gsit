<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SolutionTemplate extends Common
{
  protected $table = 'glpi_solutiontemplates';
  protected $definition = '\App\Models\Definitions\SolutionTemplate';
  protected $titles = ['Solution template', 'Solution templates'];
  protected $icon = 'edit';

  protected $appends = [
    'types',
  ];

  protected $visible = [
    'types',
  ];

  protected $with = [
    'types:id,name',
  ];

  public function types(): BelongsTo
  {
    return $this->belongsTo('\App\Models\SolutionType', 'solutiontypes_id');
  }

}
