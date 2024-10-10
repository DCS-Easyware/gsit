<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Softwareversion extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Softwareversion';

  protected $appends = [
  ];

  protected $visible = [
  ];

  protected $with = [
    'software:id,name'
  ];

  // We get all devices
  public function devices()
  {
    return $this->belongsToMany('\App\Models\Computer', 'item_softwareversion', 'softwareversion_id', 'item_id');
  }

  public function software(): BelongsTo
  {
    return $this->belongsTo('App\Models\Software');
  }
}
