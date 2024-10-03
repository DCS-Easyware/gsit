<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Softwareversion extends Common
{
  protected $definition = '\App\Models\Definitions\Softwareversion';

  protected $appends = [
  ];

  protected $visible = [
  ];

  protected $with = [
  ];

  // We get all devices
  public function devices()
  {
    return $this->belongsToMany('\App\Models\Computer', 'item_softwareversion', 'softwareversion_id', 'item_id');
  }
}
