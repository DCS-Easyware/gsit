<?php

namespace App\v1\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Slim\Routing\RouteContext;

final class Computer extends Common
{
  protected $model = '\App\Models\Computer';

  public function getAll(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Computer();
    return $this->commonGetAll($request, $response, $args, $item);
  }

  public function showItem(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Computer();
    return $this->commonShowItem($request, $response, $args, $item);
  }

  public function updateItem(Request $request, Response $response, $args): Response
  {
    $item = new \App\Models\Computer();
    return $this->commonUpdateItem($request, $response, $args, $item);
  }

  public function showOperatingSystem(Request $request, Response $response, $args): Response
  {
    global $translator;

    $item = new \App\Models\Computer();
    $view = Twig::fromRequest($request);

    $myItem = $item::with('operatingsystems')->find($args['id']);

    $operatingsystem = [];
    foreach ($myItem->operatingsystems as $os)
    {
      $osa = \App\Models\Operatingsystemarchitecture::find($os->pivot->operatingsystemarchitecture_id);
      $osv = \App\Models\Operatingsystemversion::find($os->pivot->operatingsystemversion_id);
      $ossp = \App\Models\Operatingsystemservicepack::find($os->pivot->operatingsystemservicepack_id);
      $oskv = \App\Models\Operatingsystemkernelversion::find($os->pivot->operatingsystemkernelversion_id);
      $ose = \App\Models\Operatingsystemedition::find($os->pivot->operatingsystemedition_id);
      $osln = $os->pivot->license_number;
      $oslid = $os->pivot->licenseid;
      $osid = $os->pivot->installationdate;
      $oswo = $os->pivot->winowner;
      $oswc = $os->pivot->wincompany;
      $osoc = $os->pivot->oscomment;
      $oshid = $os->pivot->hostid;

      $architecture = '';
      if ($osa !== null)
      {
        $architecture = $osa->name;
      }
      $version = '';
      if ($osv !== null)
      {
        $version = $osv->name;
      }
      $servicepack = '';
      if ($ossp !== null)
      {
        $servicepack = $ossp->name;
      }
      $kernelversion = '';
      if ($oskv !== null)
      {
        $kernelversion = $oskv->name;
      }
      $edition = '';
      if ($ose !== null)
      {
        $edition = $ose->name;
      }
      $license_number = '';
      if ($osln !== null)
      {
        $license_number = $osln;
      }
      $licenseid = '';
      if ($oslid !== null) $licenseid = $oslid;
      $installationdate = '';
      if ($osid !== null) $installationdate = $osid;
      $winowner = '';
      if ($oswo !== null) $winowner = $oswo;
      $wincompany = '';
      if ($oswc !== null) $wincompany = $oswc;
      $oscomment = '';
      if ($osoc !== null) $oscomment = $osoc;
      $hostid = '';
      if ($oshid !== null) $hostid = $oshid;

      $operatingsystem = [
        'id' => $os->id,
        'name' => $os->name,
        'architecture' => $architecture,
        'architecture_id' => $os->pivot->operatingsystemarchitecture_id,
        'version' => $version,
        'version_id' => $os->pivot->operatingsystemversion_id,
        'servicepack' => $servicepack,
        'servicepack_id' => $os->pivot->operatingsystemservicepack_id,
        'kernelversion' => $kernelversion,
        'kernelversion_id' => $os->pivot->operatingsystemkernelversion_id,
        'edition' => $edition,
        'edition_id' => $os->pivot->operatingsystemedition_id,
        'licensenumber' => $license_number,
        'licenseid' => $licenseid,
        'installationdate' => $installationdate,
        'winowner' => $winowner,
        'wincompany' => $wincompany,
        'oscomment' => $oscomment,
        'hostid' => $hostid,
      ];
    }

    $rootUrl = $this->getUrlWithoutQuery($request);
    $rootUrl = rtrim($rootUrl, '/operatingsystem');

    $viewData = new \App\v1\Controllers\Datastructures\Viewdata($myItem, $request);
    $viewData->addRelatedPages($item->getRelatedPages($rootUrl));

    $viewData->addTranslation('savebutton', $translator->translate('Save'));

    $getDef = [];
    $myItemData = [];


    $getDefs = $item->getSpecificFunction('getDefinitionOperatingSystem');

    $myItemData = [
      'name'  => $operatingsystem['name'],
      'architecture'  => [
        'id' => $operatingsystem['architecture_id'],
        'name' => $operatingsystem['architecture'],
      ],
      'kernelversion'  => [
        'id' => $operatingsystem['kernelversion_id'],
        'name' => $operatingsystem['kernelversion'],
      ],
      'version'  => [
        'id' => $operatingsystem['version_id'],
        'name' => $operatingsystem['version'],
      ],
      'servicepack'  => [
        'id' => $operatingsystem['servicepack_id'],
        'name' => $operatingsystem['servicepack'],
      ],
      'edition'  => [
        'id' => $operatingsystem['edition_id'],
        'name' => $operatingsystem['edition'],
      ],
      'licenseid'  => $operatingsystem['licenseid'],
      'licensenumber'  => $operatingsystem['licensenumber'],
    ];
    $myItemDataObject = json_decode(json_encode($myItemData));

    $viewData->addData('fields', $item->getFormData($myItemDataObject, $getDefs));
    $viewData->addData('operatingsystem', $operatingsystem);

    return $view->render($response, 'subitem/operatingsystems.html.twig', (array)$viewData);
  }

  public function showSubSoftwares(Request $request, Response $response, $args): Response
  {
    global $translator;

    $item = new \App\Models\Computer();
    $view = Twig::fromRequest($request);

    $myItem = $item::with('softwareversions.software:id,name', 'antiviruses')->find($args['id']);

    $myAntiviruses = [];
    foreach ($myItem->antiviruses as $antivirus)
    {
      $myAntiviruses[] = [
        'name'        => $antivirus->name,
        'publisher'   => $antivirus->manufacturer_id,
        'is_dynamic'  => $antivirus->is_dynamic,
        'version'     => $antivirus->antivirus_version,
        'signature'   => $antivirus->signature_version,
        'is_active'   => $antivirus->is_active,
        'is_uptodate' => $antivirus-> is_uptodate
      ];
    }

    $softwares = [];
    foreach ($myItem->softwareversions as $softwareversion)
    {
      $softwares[] = [
        'id' => $softwareversion->id,
        'name' => $softwareversion->name,
        'software' => [
          'id' => $softwareversion->software->id,
          'name' => $softwareversion->software->name,
        ]
      ];
    }

    $rootUrl = $this->getUrlWithoutQuery($request);
    $rootUrl = rtrim($rootUrl, '/softwares');

    $viewData = new \App\v1\Controllers\Datastructures\Viewdata($myItem, $request);
    $viewData->addRelatedPages($item->getRelatedPages($rootUrl));

    $viewData->addData('fields', $item->getFormData($myItem));
    $viewData->addData('softwares', $softwares);
    $viewData->addData('antiviruses', $myAntiviruses);

    $viewData->addTranslation('software', $translator->translatePlural('Software', 'Software', 1));
    $viewData->addTranslation('version', $translator->translatePlural('Version', 'Versions', 1));

    return $view->render($response, 'subitem/softwares.html.twig', (array)$viewData);
  }

  public function showHistory(Request $request, Response $response, $args)
  {
    $item = new \App\Models\Computer();
    $view = Twig::fromRequest($request);

    $session = new \SlimSession\Helper();

    // Load the item
    $myItem = $item->find($args['id']);

    $logs = \App\Models\Log::
        where('item_type', 'App\v1\Models\Computer')
      ->where('item_id', $myItem->id)
      ->get();

    $rootUrl = $this->getUrlWithoutQuery($request);
    $rootUrl = rtrim($rootUrl, '/history');

    // form data
    $viewData = new \App\v1\Controllers\Datastructures\Viewdata();
    $viewData->addHeaderTitle('GSIT - ' . $item->getTitle(1));
    $viewData->addHeaderMenu(\App\v1\Controllers\Menu::getMenu($request));
    $viewData->addHeaderRootpath(\App\v1\Controllers\Toolbox::getRootPath($request));
    $viewData->addHeaderName($item->getTitle(1));
    $viewData->addHeaderId($myItem->id);
    $viewData->addIconId($item->getIcon());
    // $viewData->addColorId($myItem->getColor());

    $viewData->addRelatedPages($item->getRelatedPages($rootUrl));

    $viewData->addData('history', $logs);

    if ($session->exists('message'))
    {
      $viewData['message'] = $session->message;
      $session->delete('message');
    }

    return $view->render($response, 'subitem/history.html.twig', (array)$viewData);
  }

  protected function getInformationTop($item, $request)
  {
    global $translator, $basePath;

    return [
      [
        'key'   => 'operatingsystem',
        'value' => $translator->translatePlural('Operating system', 'Operating systems', 1),
        'link'  => $basePath . '/view/computers/' . $item->id . '/operatingsystem',
      ],
      [
        'key'   => 'softwares',
        'value' => $translator->translatePlural('Software', 'Software', 2),
        'link'  => $basePath . '/view/computers/' . $item->id . '/softwares',
      ],
    ];
  }

  protected function getInformationBottom($item, $request)
  {
    return [
      [
        'key'   => '1',
        'value' => 'Operating system : Windows 11 pro',
        'link'  => 'free.fr',
      ],
    ];
  }
}
