<?php

namespace App\v1\Controllers\Fusioninventory;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Spatie\ArrayToXml\ArrayToXml;

final class Computer extends \App\v1\Controllers\Common
{
  public function importComputer($dataStr)
  {
    $dataObj = simplexml_load_string($dataStr);
    // file_put_contents('/tmp/fusion.log', print_r($dataObj, true));

    // blacklists

    // clean data (delete noprintable chars for example)

    // rule

    // dictionnaries

    $computer = \App\Models\Computer::where('serial', $dataObj->CONTENT->BIOS->SSN)->first();
    if (is_null($computer))
    {
      $computer = new \App\Models\Computer();
    }
    $computer->name = $dataObj->CONTENT->HARDWARE->NAME;
    $computer->uuid = $dataObj->CONTENT->HARDWARE->UUID;
    $computer->serial = $dataObj->CONTENT->BIOS->SSN;
    $computer->otherserial = $this->getOtherSerial($dataObj);
    $computer->manufacturer_id = $this->getManufacturer($dataObj);
    $computer->computertype_id = $this->getType($dataObj);
    // computermodel_id

    $computer->save();

    $this->operatingSystem($dataObj, $computer);
    $this->softwares($dataObj, $computer);
    $this->antivirus($dataObj, $computer);
  }

  private function getOtherSerial(object $dataObj)
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

  private function operatingSystem(object $dataObj, \App\Models\Computer $computer)
  {
  }

  private function softwares(object $dataObj, \App\Models\Computer $computer)
  {
    if (property_exists($dataObj->CONTENT, 'SOFTWARES'))
    {
      $versionIds = [];
      $content = json_decode(json_encode($dataObj->CONTENT));
      foreach ($content->SOFTWARES as $contentSoftware)
      {
        if (empty($contentSoftware->NAME) || !is_string($contentSoftware->NAME))
        {
          continue;
        }
        $software = \App\Models\Software::firstOrCreate(
          [
            'name'      => $contentSoftware->NAME,
            'entity_id' => 0
          ],
          [] // manage manufacturer? comment?
        );
        if (!property_exists($contentSoftware, 'VERSION'))
        {
          continue;
        }
        $softwareversion = \App\Models\Softwareversion::firstOrCreate(
          [
            'name'        => (string) $contentSoftware->VERSION,
            'entity_id'   => 0,
            'software_id' => $software->id
          ],
          [] // operatingsystem?
        );
        // file_put_contents('/tmp/softwares', print_r($softwareversion, true));
        $versionIds[] = $softwareversion->id;
      }
      $computer->softwareversions()->syncWithPivotValues($versionIds, ['is_dynamic' => true]);
    }
  }

  private function antivirus(object $dataObj, \App\Models\Computer $computer)
  {
    if (property_exists($dataObj->CONTENT, 'SOFTWARES'))
    {
      // $content = json_decode(json_encode($dataObj->CONTENT));
      // foreach ($content->ANTIVIRUS as $contentAntivirus)
      // {
        $antivirus = \App\Models\Computerantivirus::firstOrCreate(
          [
            'name'        => (string) $dataObj->CONTENT->ANTIVIRUS->NAME,
            'computer_id' => $computer->id
          ],
          []
        );
        $antivirus->antivirus_version = $dataObj->CONTENT->ANTIVIRUS->VERSION;
        $antivirus->signature_version = $dataObj->CONTENT->ANTIVIRUS->BASE_VERSION;
        $antivirus->is_active = $dataObj->CONTENT->ANTIVIRUS->ENABLED;
        $antivirus->is_uptodate = $dataObj->CONTENT->ANTIVIRUS->UPTODATE;
        $antivirus->is_dynamic = true;
        $manufacturer = \App\Models\Manufacturer::firstOrCreate(
          [
            'name' => $dataObj->CONTENT->ANTIVIRUS->COMPANY,
          ]
        );
        $antivirus->manufacturer_id = $manufacturer->id;

        $antivirus->save();
      // }
    }
  }
}
