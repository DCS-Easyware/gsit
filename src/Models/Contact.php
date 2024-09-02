<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Common
{
  protected $table = 'glpi_contacts';
  protected $definition = '\App\Models\Definitions\Contact';
  protected $titles = ['Contact', 'Contacts'];
  protected $icon = 'user tie';

  protected $appends = [
    'type',
    'title',
  ];

  protected $visible = [
    'type',
    'title',
  ];

  protected $with = [
    'type:id,name',
    'title:id,name',
  ];

  public function type(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Contacttype', 'contacttypes_id');
  }
  public function title(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Usertitle', 'usertitles_id');
  }


}
