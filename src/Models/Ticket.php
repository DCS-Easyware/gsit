<?php

namespace App\Models;


class Ticket extends Common
{
  protected $table = 'glpi_tickets';
  protected $definition = '\App\Models\Definitions\Ticket';
  protected $titles = ['Ticket', 'Tickets'];
  protected $icon = 'hands helping';

}
