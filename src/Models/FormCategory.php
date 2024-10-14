<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormCategory extends Common
{
  protected $table = 'glpi_plugin_formcreator_categories';
  protected $definition = '\App\Models\Definitions\FormCategory';
  protected $titles = ['Form category', 'Form categories'];
  protected $icon = 'edit';
}
