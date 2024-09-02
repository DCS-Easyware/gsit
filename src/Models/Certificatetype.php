<?php

namespace App\Models;


class Certificatetype extends Common
{
  protected $table = 'glpi_certificatetypes';
  protected $definition = '\App\Models\Definitions\CertificateType';

}
