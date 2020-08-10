<?php

include $_SERVER['DOCUMENT_ROOT'] . "/inc/main.php";
if (isset($_SESSION['user'])) {
    if (isset($_GET['domain'])) {
        $domain = $_GET['domain'];
        if (!empty($_GET['email'])) {
            $email = $_GET['email'];
        } else {
            $email = "admin@".$domain;
        }
        if (!empty($_GET['standart'])) {
            $standart = $_GET['standart'];
        } else {
            $standart = "true";
        }
        if (!empty($_GET['pls'])) {
            $pls = $_GET['pls'];
            $plugins = "";
            foreach ($pls as $k => $plu) {
                if($k == 0) {
                    $plugins =   $plu["pl"];
                    continue;
                }
                $plugins = $plugins . "*" . $plu["pl"];
            }
        } 
        
        $command = '/usr/bin/sudo /usr/local/vesta/bin/v-sam-create-wpnew "' . $domain . '" "' . $email . '" "' . $user . '" "' . $standart. '" "' . $plugins. '"   2>&1';
        exec($command, $output, $return_vari);
        $ddata = implode('<br/>', $output);

        $ot = explode('~~~~', $ddata);
        if (!empty($ot['1'])) {
            echo ' <div class="panel panel-info">
    <div class="panel-heading">Install Detail</div>
    <div class="panel-body">';
           // var_dump($GET['pls'], $plugins);
            print_r($ot['1']);
            echo '</div>
  </div>';
            ob_flush();
            flush();
        }
    }
} else {
    echo '<h2>your login expire... please re login</h2>';
    ob_flush();
    flush();
}
?>
