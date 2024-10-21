<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends \App\Models\Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Forms\Section';
  protected $titles = ['Section', 'Sections'];
  protected $icon = 'cubes';

  public function questions(): BelongsToMany
  {
    return $this->belongsToMany('\App\Models\Forms\Question');
  }
}
