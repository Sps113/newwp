<?php

error_reporting(NULL);

ob_start();
$TAB = 'WPN';

// Main include
include($_SERVER['DOCUMENT_ROOT']."/inc/main.php");
if (isset($_SESSION['user'])) {

	echo '<!DOCTYPE html>
<html lang="en">
<head>
  <title>Wordpress Installer</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="/css/styles.min.css">


</head>
<body>
  ';


echo '<div class="container"><h2>Wordpress Installer</h2>';
	exec (VESTA_CMD . "v-list-user ".$user." json", $outputi, $return_vari);
	$datai = json_decode(implode('', $outputi), true);
$dati = array_reverse($datao,true);
$email=$dati["$user"]['CONTACT'];
	print_r($email);
	exec (VESTA_CMD."v-list-web-domains $user json", $output, $return_var);
$data = json_decode(implode('', $output), true);
$data = array_reverse($data,true);
echo '<div  id="wpform">
    <div class="form-group">
      <label for="domain">Domain:</label>';
echo '<select name="domain" id="domain" class="form-control">';
foreach($data as $dm=>$key){
echo '<option value="'.$dm.'">'.$dm.'</option>';
 
}
echo'</select></div>';
echo "\n";

fclose($fh);
echo ' <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" placeholder="Enter custom email" name="email" value="'.$email.'"> 
        <b>Standart install</b><input type="checkbox" class="form-control-wp" id="check" name="checkbox" style="display:inline !important;width: 10%;" >';
        
$file = fopen(__DIR__ ."/list.txt", "r");
$i = 0;
echo '<table class="detail"><tbody><tr><th>Name</th><th>Install</th><th>Activate</th></tr>';
while ($line = fgets($file)) {
    echo "<tr><td>".$line.'</td><td><input type="checkbox" class="form-control-wp" id="check_'.$i.'" name="checkbox" style="display:inline !important;" checked></td><td><input type="checkbox" class="form-control-wp" id="activate_'.$i.'" name="checkbox" style="display:inline !important;" ></td></tr>';
    $i++;
}        
echo '</tbody></table>';
        
        
echo   '</div> 
        <input type="button" onclick="wpinstall()" class="btn btn-default" value="Install">
        <br/>
	  <div id="loading" style="display:none;"><p class="text-center"><img src="https://i.extraimage.info/pix/KLtQ0.gif" border="0"></p></div>
	 <div id="output"></div>
 ';
	

?>
<script> 
function wpinstall() {
   
	var e = document.getElementById("domain");
	var email = document.getElementById("email").value;
    var domain = e.options[e.selectedIndex].value;
    var check = document.getElementById("check").checked ? "true": "false";
    
    var x = document.getElementById("loading");
    x.style.display = "block";
    var i = 0;
    var ch,ac; 
    var plugins = [];
    while (document.getElementById("check_" + i )) {
        var ch = document.getElementById("check_" + i );
        var ac = document.getElementById("activate_" + i );
        console.log(i, ch.checked, ac.checked);
        var pl = 0; 
        if (ch.checked) pl = 1;
        if (ch.checked && ac.checked) pl = 2;
        plugins.push({ pl: pl });
        i++;
    } 
    var plstr = '';
    if (!document.getElementById("check").checked) {
        plstr = "&" + serialize({"pls":plugins});
    }
    data=samgrab('api.php?domain=' + domain + '&email=' + email + '&standart=' + check + plstr  );
    document.getElementById("output").innerHTML=data;
    x.style.display = "none";
}
function samgrab(link){
    var result="";
    $.ajax({
        url:link,
        async:false,
        success:function(data){
            result=data;}
            });
    return result;
}
$('#check').click(function() {
    $('.detail').toggle();
});


var serialize = function(obj, prefix) {
  var str = [],
    p;
  for (p in obj) {
    if (obj.hasOwnProperty(p)) {
      var k = prefix ? prefix + "[" + p + "]" : p,
        v = obj[p];
      str.push((v !== null && typeof v === "object") ?
        serialize(v, k) :
        encodeURIComponent(k) + "=" + encodeURIComponent(v));
    }
  }
  return str.join("&");
}
</script>
<?php }else{
	header("Location: /login/");
	
}
