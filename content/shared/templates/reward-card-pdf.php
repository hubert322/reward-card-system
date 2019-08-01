<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv=Content-Type content="text/html; charset=UTF-8">
</head>
<style>
  .page
  {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-box-pack: start;
  }

  .row
  {
    display: -webkit-box;
    -webkit-box-orient: horizontal;
    -webkit-box-pack: justify;
  }

  .page-break
  {
    page-break-before: always;
  }

  .item
  {
    border: 1px dotted black;
  }
</style>
<body>
<?php for ($i = 0; $i * 6 < sizeof ($qrCodeSources); ++$i) { ?>
  <div class="page">
      <?php for($j = 0; $j < 3 && $i + $j * 2 < sizeof ($qrCodeSources); ++$j) { ?>
        <div class="row">
            <?php for ($k = 0; $k < 2 && $i * 6 + $j * 2 + $k < sizeof ($qrCodeSources); ++$k) { ?>
              <div class="item">
                <img src="data:image/png;base64,<?= $qrCodeSources[$i * 6 + $j * 2 + $k]['qrCodeSource'] ?>"
                     alt="<?= $qrCodeSources[$i * 6 + $j * 2 + $k]['formattedInputCode'] ?>"
                     style="margin-top: 15px;"
                />
                <p>Input Code: <?= $qrCodeSources[$i * 6 + $j * 2 + $k]['formattedInputCode'] ?></p>
                <p>Scan the QR code or input the code to earn <?= $qrCodeSources[$i * 6 + $j * 2 + $k]['starAmount'] ?> stars!</p>
              </div>
            <?php } ?>
        </div>
      <?php } ?>
  </div>
  <?php if (($i + 1) * 6 < sizeof ($qrCodeSources)) { ?>
      <div class="page-break"></div>
  <?php } ?>
<?php } ?>
</body>
</html>