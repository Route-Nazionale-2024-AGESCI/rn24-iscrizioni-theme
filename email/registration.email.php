<?php
include('header.mail.php'); ?>
Carissimi capi del gruppo <b>[RN24_GRUPPO]</b>,<br>
benvenuti nella <b>Route Nazionale delle Comunit&agrave; Capi 2024</b>!<br><br>
Per procedere effettua l'accesso con le credenziali create per il tuo gruppo.<br>
<p><i>Password</i>: <b>[RN24_PASSWORD]</b></p>
<br>
<br>
<table width="100%" cellpadding="1" cellspacing="0" border="0">
    <tbody>
    <tr>
        <td align="center" class="article-content" width="25%"></td>
        <td align="center" class="article-content" width="50%" style="border-radius: 2px;" bgcolor="#6D5095">
            <a target="_blank" style="font-family:'Montserrat',sans-serif;font-weight: bold;display: inline-block;color: #fff;text-decoration: none;padding: 8px 12px; border: 1px solid #6D5095;border-radius: 2px;" href="[RN24_BASE_URL]/login?username=[RN24_EMAIL]">
                Entra
            </a>
        </td>
        <td align="center" class="article-content" width="25%"></td>
    </tr>
    </tbody>
</table>
<br />
Grazie,<br />
<i>Lo staff della Route Nazionale Comunità Capi 2024</i>
<br />
<?php
require_once('footer.mail.php');