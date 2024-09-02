<?php

namespace App\Models;


class Clustertype extends Common
{
  protected $table = 'glpi_clustertypes';
  protected $definition = '\App\Models\Definitions\ClusterType';

}
