<?php

namespace App\v1\Controllers\Fusioninventory;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Spatie\ArrayToXml\ArrayToXml;
use App\v1\Controllers\Common;

final class Computer extends Common
{
  public function importComputer($dataStr)
  {
    $dataObj = simplexml_load_string($dataStr);
    // file_put_contents('/tmp/fusion.log', print_r($dataObj, true));

    // blacklists

    // clean data (delete noprintable chars for example)

    // rule

    // dictionnaries


    $computer = \App\Models\Computer::find(35869);
    $computer->name = $dataObj->CONTENT->HARDWARE->NAME;
    $computer->uuid = $dataObj->CONTENT->HARDWARE->UUID;
    $computer->serial = $dataObj->CONTENT->BIOS->SSN;
    $computer->otherserial = $this->getOtherSerial($dataObj);
    $computer->manufacturer_id = $this->getManufacturer($dataObj);
    $computer->computertype_id = $this->getType($dataObj);
    // computermodel_id

    $computer->save();

    $this->operatingSystem($dataObj, $computer);
  }

  private function getOtherSerial($dataObj)
  {
    if (
        property_exists($dataObj->CONTENT, 'BIOS') &&
        property_exists($dataObj->CONTENT->BIOS, 'ASSETTAG')
    )
    {
      return $dataObj->CONTENT->BIOS->ASSETTAG;
    }
    return null;
  }

  private function getManufacturer($dataObj)
  {
    if (property_exists($dataObj->CONTENT, 'BIOS'))
    {
      $fields = ['SMANUFACTURER', 'MMANUFACTURER', 'BMANUFACTURER'];
      foreach ($fields as $field)
      {
        if (
            property_exists($dataObj->CONTENT->BIOS, $field) &&
            !empty($dataObj->CONTENT->BIOS->{$field})
        )
        {
          $name = $dataObj->CONTENT->BIOS->{$field};
          $manufacturer = \App\Models\Manufacturer::where('name', $name)->first();
          if (is_null($manufacturer))
          {
            $manufacturer = new \App\Models\Manufacturer();
            $manufacturer->name = $name;
            $manufacturer->save();
          }
          return $manufacturer->id;
        }
      }
    }
    return 0;
  }

  private function getType($dataObj)
  {
    $fields = [
      ['HARDWARE', 'CHASSIS_TYPE'],
      ['BIOS', 'TYPE'],
      ['BIOS', 'MMODEL'],
      ['HARDWARE', 'VMSYSTEM'],
    ];
    foreach ($fields as $field)
    {
      if (
          property_exists($dataObj->CONTENT, $field[0]) &&
          property_exists($dataObj->CONTENT->{$field[0]}, $field[1]) &&
          !empty($dataObj->CONTENT->{$field[0]}->{$field[1]})
      )
      {
        $name = $dataObj->CONTENT->{$field[0]}->{$field[1]};
        $model = \App\Models\Computermodel::where('name', $name)->first();
        if (is_null($model))
        {
          $model = new \App\Models\Computermodel();
          $model->name = $name;
          $model->save();
        }
        return $model->id;
      }
    }
    return 0;
  }

  private function operatingSystem($dataStr, \App\Models\Computer $computer)
  {

  }
}
