<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <title><?php echo $title ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  </head>
  <body style="font-family: Arial; font-size: 14px;">
    <table cellpadding="0" cellspacing="0" width="600" style="margin: 0 auto; color: #666;">
      <tbody>
        <tr>
          <td style="border-bottom: thin solid #ddd; padding-bottom: 10px; text-align: center;">
            <h1 style="margin: 0; font-weight: normal; font-size: 1.8em;"><?php echo $title ?></h1>
          </td>
        </tr>
        <tr>
          <td style="text-align: justify; padding: 10px 0 20px 0;">
            <?php echo $message ?>
          </td>
        </tr>
        <tr>
          <td style="border-top: thin solid #ddd; text-align: center; padding-top: 10px; font-size: 0.9em;">
            &copy; <?php echo date('Y') ?> - <?php echo url_for('@homepage', true) ?><br />
            <a href="<?php echo url_for('@homepage', true) ?>" style="color: #2294e1; text-decoration: none;"><?php echo __('Visit website', array(), 'sf_cms') ?></a>
          </td>
        </tr>
      </tbody>
    </table>
  </body>
</html>