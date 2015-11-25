<?php
$_SERVER['PHP_SELF'] = 'cron.php';

include ('/Donnees/www/glpi090/inc/includes.php');

$file = '/home/ddurieux/glpi.csv';

$user = new User();
$profile_user = new Profile_User();
$userEmail = new UserEmail();

// | entity | nom | prenom | login | email | telephone | lieu |

$row = 1;
if (($handle = fopen($file, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
       if (!($data[1] == ''
	 && $data[2] == '')) {
          
          $data[4] = trim(strtolower($data[4]));
          for ($ii=0; $ii < count($data); $ii++) {

//              $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#');
//              $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#', '#');

//              $data[$ii] = preg_replace( '/[^0-9A-Za-z\-_@\.]/', '', $data[$ii]);      
//              $data[$ii] = str_replace($a, $b, $data[$ii]);

          }

       if ($data[4] != '') {
       echo ".";
       $users = $user->find("`name`='".$data[4]."'", '', 1);
       $input = array(
          'name' => $data[4],
//          'realname' => addslashes($data[1]),
          'realname' => str_replace("'", "\'", $data[1]),
          'firstname' => $data[2]
       );
       $entities_id = 1; // Student
       if ($data[0] == 'EDUCATION') {
          $entities_id = 2;
       }
       if (count($users) > 0) {
          $u = current($users);
          $input['id'] = $u['id'];
          $mails = $userEmail->find("`users_id`='".$u['id']."'"
                  . " AND `email`='".$data[4]."'", '', 1);
          if (count($mails) == 0) {
             $input['_useremails'] = array($data[4]);
          } else {
             $mail = current($mails);
             $input['_default_email'] = $mail['id'];
             $input['_useremails'] = array($mail['id'] => $data[4]);
          }
          $user->update($input);
          $DB->query("DELETE FROM `glpi_profiles_users`"
                  . " WHERE `users_id`='".$u['id']."'"
                  . " AND `is_dynamic`='1'");
       } else {
          $input['_useremails'] = array( '-1' => $data[4]);
          $users_id = $user->add($input);
          if (!$users_id) {
print_r($_SESSION["MESSAGE_AFTER_REDIRECT"]);
$_SESSION["MESSAGE_AFTER_REDIRECT"] = '';
             echo "error on add\n";
             print_r($input);
          } else {
             $p_input = array(
                'users_id'     => $users_id,
                'profiles_id'  => 1, // self-service
                'entities_id'  => $entities_id,
                'is_recursive' => 0,
                'id_dynamic'   => 0
             );
             $profile_user->add($p_input);
             $DB->query("DELETE FROM `glpi_profiles_users`"
                     . " WHERE `users_id`='".$users_id."'"
                     . " AND `is_dynamic`='1'");
          }
       }
      }
     }
    }
    fclose($handle);
}
?>
