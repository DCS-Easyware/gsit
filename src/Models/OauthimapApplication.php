<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OauthimapApplication extends Common
{
  protected $table = 'glpi_plugin_oauthimap_applications';
  protected $definition = '\App\Models\Definitions\OauthimapApplication';
  protected $titles = ['Oauth IMAP application', 'Oauth IMAP applications'];
  protected $icon = 'edit';
}
