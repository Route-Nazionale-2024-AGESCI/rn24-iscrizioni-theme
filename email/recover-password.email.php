<?php
include('header.mail.php'); ?>
Hai richiesto il reset della password per l'accesso al portale di iscrzione alla <b>Route nazionale delle Comunit&agrave; capi 2024</b>
 per il gruppo <b>[RN24_GRUPPO]</b>.<br>
<br>
<br>
<table width="100%" cellpadding="1" cellspacing="0" border="0">
    <tbody>
    <tr>
        <td align="center" class="article-content" width="25%"></td>
        <td align="center" class="article-content" width="50%" style="border-radius: 2px;" bgcolor="#6D5095">
            <a target="_blank" style="font-family:'Montserrat',sans-serif;font-weight: bold;display: inline-block;color: #fff;text-decoration: none;padding: 8px 12px; border: 1px solid #6D5095;border-radius: 2px;" href="[RN24_BASE_URL]/recupera-password/?email=[RN24_EMAIL]&key=[RN24_RESET_KEY]">
                Recupera password
            </a>
        </td>
        <td align="center" class="article-content" width="25%"></td>
    </tr>
    </tbody>
</table>
<br />
Grazie,<br />
<i>Lo staff della Route nazionale Comunità capi 2024</i>
<br />
<?php
require_once('footer.mail.php');