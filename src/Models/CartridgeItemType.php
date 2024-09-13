<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CartridgeItemType extends Common
{
  protected $table = 'glpi_cartridgeitemtypes';
  protected $definition = '\App\Models\Definitions\CartridgeItemType';
  protected $titles = ['Cartridge type', 'Cartridge types'];
  protected $icon = 'edit';

}
