<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ITILFollowupTemplate extends Common
{
  protected $table = 'glpi_itilfollowuptemplates';
  protected $definition = '\App\Models\Definitions\ITILFollowupTemplate';
  protected $titles = ['Followup template', 'Followup templates'];
  protected $icon = 'edit';

  protected $appends = [
    'source',
  ];

  protected $visible = [
    'source',
  ];

  protected $with = [
    'source:id,name',
  ];

  public function source(): BelongsTo
  {
    return $this->belongsTo('\App\Models\RequestType', 'requesttypes_id');
  }
}
