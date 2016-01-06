<?php

if (strpos($_SERVER['PHP_SELF'],"linkTicket.php")) {
   include ('../inc/includes.php');
   header("Content-Type: text/html; charset=UTF-8");
   Html::header_nocache();
}
if (!defined('GLPI_ROOT')) {
   die("Can not acces directly to this file");
}
$values = array();
if (isset($_GET['tickets_id_2'])) {
   $values = json_decode(Toolbox::stripslashes_deep($_GET['tickets_id_2']), TRUE);
}

$ID = 0;
echo "<table class='tab_format' width='100%'><tr><td width='30%'>";

Ticket_Ticket::dropdownLinks('_link[]',
                             (isset($_GET['_link'])?$_GET['_link']:''));
//echo "<input type='text' name='_link[tickets_id_1]' value='$ID'>\n";
echo "</td><td width='70%'>";
$linkparam = array('name'        => '_linkid[]',
                   'displaywith' => array('id'));
if (isset($values['tickets_id_2'])) {
   $linkparam['value'] = $values['tickets_id_2'];
} else if (isset($_GET['_linkid'])) {
   $linkparam['value'] = $_GET['_linkid'];;
}

Ticket::dropdown($linkparam);
echo "</td></tr></table>";

?>