<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Common
{
  protected $table = 'glpi_suppliers';
  protected $definition = '\App\Models\Definitions\Supplier';
  protected $titles = ['Supplier', 'Suppliers'];
  protected $icon = 'dolly';

  protected $appends = [
    'type',
  ];

  protected $visible = [
    'type',
  ];

  protected $with = [
    'type:id,name',
  ];

  public function type(): BelongsTo
  {
    return $this->belongsTo('\App\Models\SupplierType', 'suppliertypes_id');
  }


}
