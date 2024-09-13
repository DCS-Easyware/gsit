<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CertificateType extends Common
{
  protected $table = 'glpi_certificatetypes';
  protected $definition = '\App\Models\Definitions\CertificateType';
  protected $titles = ['Certificate type', 'Certificate types'];
  protected $icon = 'edit';

}
