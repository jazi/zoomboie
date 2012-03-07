<?php
// ===========================================================================================
//
// PLogin.php
//
// Show a login-form, ask for user name and password.
//
// -------------------------------------------------------------------------------------------
//
if(!isset($indexIsVisited)) die('No direct access to pagecontroller is allowed.');
$request = isset($_GET['request']) ? $_GET['request'] : 'home';

$html = <<<EOD
<p>Ange din användare och löensenord för att logga in.
<em>mikael - hemligt, 
doe - doe, 
user-pass</em></p><br /><br />

<table class='login';>
<th class='login' colspan='2'>Logga in</th>

<form action="?p=loginp" method="post">
<input type='hidden' name='redirect' value='{$request}'>
<tr>
<td class='login'><label for="nameUser">Användare:</label></td>
<td><input id=nameUser  type="text" name="nameUser"></td>
</tr>
<tr>
<td class='login'><label for="passwordUser">Lösenord:</label></td>
<td><input id=passwordUser type="password" name="passwordUser"></td>
</tr>
<tr><td> </td><td> </td></tr>
<tr><td></td>
<td><button type="submit" name="submit">Logga in</button></td>
</tr>

</form>
</table>
<!--
<p><a href="PGetPassword.php">Skapa en ny användare!</a></p>
<p><a href="PGetPassword.php">Jag har glömt mitt lösenord!</a></p>
-->
EOD;

// -------------------------------------------------------------------------------------------
//
$page = new CHTMLPage();
$page->PrintPage('Login', '', $html, '');

?>