<?php
$brands = [
  ['file' => 'jockey.png',        'name' => 'Jockey'],
  ['file' => 'livpure-smart.png', 'name' => 'Livpure Smart'],
  ['file' => 'nasher-miles.png',  'name' => 'Nasher Miles'],
  ['file' => 'hrx.png',           'name' => 'HRX'],
  ['file' => 'uppercase.png',     'name' => 'Uppercase'],
  ['file' => 'snitch.png',        'name' => 'Snitch'],
  ['file' => 'lancer-shoes.png',  'name' => 'Lancer Shoes'],
  ['file' => 'egoss.png',         'name' => 'Egoss'],
  ['file' => 'depo.png',          'name' => 'Depo'],
];
?>
<section class="brands-section">
  <div class="container">
    <h2 class="section-title appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="200">Brands on StockOut</h2>
  </div>
  <div class="brands-marquee">
    <div class="brands-track">
      <?php foreach ([false, true] as $isClone): ?>
        <?php foreach ($brands as $brand): ?>
          <div class="brand-tile"<?= $isClone ? ' aria-hidden="true"' : '' ?>>
            <img src="uploads/brands/<?= $brand['file'] ?>" alt="<?= $isClone ? '' : $brand['name'] ?>" loading="lazy" width="600" height="300">
          </div>
        <?php endforeach; ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>
