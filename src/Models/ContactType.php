<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContactType extends Common
{
  protected $table = 'glpi_contacttypes';
  protected $definition = '\App\Models\Definitions\ContactType';
  protected $titles = ['Contact type', 'Contact types'];
  protected $icon = 'edit';

}
