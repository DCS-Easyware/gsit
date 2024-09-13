<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ITILCategory extends Common
{
  protected $table = 'glpi_itilcategories';
  protected $definition = '\App\Models\Definitions\ITILCategory';
  protected $titles = ['ITIL category', 'ITIL categories'];
  protected $icon = 'edit';

  protected $appends = [
    'category',
    'users',
    'groups',
    'knowbaseitemcategories',
    'tickettemplates_demand',
    'tickettemplates_incident',
    'changetemplates',
    'problemtemplates',
  ];

  protected $visible = [
    'category',
    'users',
    'groups',
    'knowbaseitemcategories',
    'tickettemplates_demand',
    'tickettemplates_incident',
    'changetemplates',
    'problemtemplates',
  ];

  protected $with = [
    'category:id,name',
    'users:id,name',
    'groups:id,name',
    'knowbaseitemcategories:id,name',
    'tickettemplates_demand:id,name',
    'tickettemplates_incident:id,name',
    'changetemplates:id,name',
    'problemtemplates:id,name',
  ];

  public function category(): BelongsTo
  {
    return $this->belongsTo('\App\Models\ITILCategory', 'itilcategories_id');
  }

  public function users(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'users_id');
  }

  public function groups(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Group', 'groups_id');
  }

  public function knowbaseitemcategories(): BelongsTo
  {
    return $this->belongsTo('\App\Models\KnowbaseItemCategory', 'knowbaseitemcategories_id');
  }

  public function tickettemplates_demand(): BelongsTo
  {
    return $this->belongsTo('\App\Models\TicketTemplate', 'tickettemplates_id_demand');
  }

  public function tickettemplates_incident(): BelongsTo
  {
    return $this->belongsTo('\App\Models\TicketTemplate', 'tickettemplates_id_incident');
  }

  public function changetemplates(): BelongsTo
  {
    return $this->belongsTo('\App\Models\ChangeTemplate', 'changetemplates_id');
  }

  public function problemtemplates(): BelongsTo
  {
    return $this->belongsTo('\App\Models\ProblemTemplate', 'problemtemplates_id');
  }
}
