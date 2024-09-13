<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PhoneType extends Common
{
  protected $table = 'glpi_phonetypes';
  protected $definition = '\App\Models\Definitions\PhoneType';
  protected $titles = ['Phone type', 'Phone types'];
  protected $icon = 'edit';

}
