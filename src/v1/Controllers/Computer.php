<?php

namespace App\v1\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Slim\Routing\RouteContext;

final class Computer extends Common
{
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
    foreach ($myItem->operatingsystems as $os) {
      $osa = \App\Models\Operatingsystemarchitecture::find($os->pivot->operatingsystemarchitecture_id);
      $osv = \App\Models\Operatingsystemversion::find($os->pivot->operatingsystemversion_id);
      $ossp = \App\Models\Operatingsystemservicepack::find($os->pivot->operatingsystemservicepack_id);
      $oskv = \App\Models\Operatingsystemkernelversion::find($os->pivot->operatingsystemkernelversion_id);
      $ose = \App\Models\Operatingsystemedition::find($os->pivot->operatingsystemedition_id);
      $osln = $os->pivot->license_number;
      $oslid = $os->pivot->licenseid;

      $architecture = '';
      if ($osa !== null) $architecture = $osa->name;
      $version = '';
      if ($osv !== null) $version = $osv->name;
      $servicepack = '';
      if ($ossp !== null) $servicepack = $ossp->name;
      $kernelversion = '';
      if ($oskv !== null) $kernelversion = $oskv->name;
      $edition = '';
      if ($ose !== null) $edition = $ose->name;
      $license_number = '';
      if ($osln !== null) $license_number = $osln;
      $licenseid = '';
      if ($oslid !== null) $licenseid = $oslid;

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
      ];
    }

    $rootUrl = $this->getUrlWithoutQuery($request);
    $rootUrl = rtrim($rootUrl, '/operatingsystem');

    $viewData = new \App\v1\Controllers\Datastructures\Viewdata();
    $viewData->addHeaderTitle('GSIT - ' . $item->getTitle(1));
    $viewData->addHeaderMenu(\App\v1\Controllers\Menu::getMenu($request));
    $viewData->addHeaderRootpath(\App\v1\Controllers\Toolbox::getRootPath($request));
    $viewData->addHeaderName($item->getTitle(1));
    $viewData->addHeaderId($myItem->id);
    $viewData->addIconId($item->getIcon());

    $viewData->addRelatedPages($item->getRelatedPages($rootUrl));

    $viewData->addTranslation('savebutton', $translator->translate('Save'));

    $getDef = [];
    $myItemData = [];

/*
    $getDef = [
      [
        'id'    => 1,
        'title' => $translator->translate('Name'),
        'type'  => 'input',
        'name'  => 'name',
      ],
      [
        'id'    => 31,
        'title' => $translator->translatePlural('Architecture', 'Architectures', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'architecture',
        'dbname' => 'operatingsystemarchitecture_id',
        'itemtype' => '\App\Models\Operatingsystemarchitecture',
      ],
    ];
    $myItemData = [
      'name'  => $operatingsystem['name'],
      'architecture'  => [
        'id' => $operatingsystem['architecture_id'],
        'name' => $operatingsystem['architecture'],
      ],
    ];

    var_dump($myItem);
    var_dump($item->getFormData($myItemData, $getDef));
    die();
*/
    $viewData->addData('fields', $item->getFormData($myItemData, $getDef));
    $viewData->addData('operatingsystem', $operatingsystem);

    return $view->render($response, 'subitem/operatingsystems.html.twig', (array)$viewData);
  }

  public function showSoftwares(Request $request, Response $response, $args): Response
  {
    global $translator;

    $item = new \App\Models\Computer();
    $view = Twig::fromRequest($request);

    $myItem = $item::with('softwareversions.software:id,name')->find($args['id']);

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

    $viewData = new \App\v1\Controllers\Datastructures\Viewdata();
    $viewData->addHeaderTitle('GSIT - ' . $item->getTitle(1));
    $viewData->addHeaderMenu(\App\v1\Controllers\Menu::getMenu($request));
    $viewData->addHeaderRootpath(\App\v1\Controllers\Toolbox::getRootPath($request));
    $viewData->addHeaderName($item->getTitle(1));
    $viewData->addHeaderId($myItem->id);
    $viewData->addIconId($item->getIcon());

    $viewData->addRelatedPages($item->getRelatedPages($rootUrl));

    $viewData->addData('fields', $item->getFormData($myItem));
    $viewData->addData('softwares', $softwares);

    $viewData->addTranslation('software', $translator->translatePlural('Software', 'Software', 1));
    $viewData->addTranslation('version', $translator->translatePlural('Version', 'Versions', 1));

    return $view->render($response, 'subitem/softwares.html.twig', (array)$viewData);
  }
}
