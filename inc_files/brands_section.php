<?php
$brands = [
  ['file' => 'jockey.png',        'name' => 'Jockey', 'search' => 'Jockey'],
  ['file' => 'livpure-smart.png', 'name' => 'Livpure Smart', 'search' => 'Livpure'],
  ['file' => 'nasher-miles.png',  'name' => 'Nasher Miles', 'search' => 'Nasher Miles'],
  ['file' => 'hrx.png',           'name' => 'HRX', 'search' => 'HRX'],
  ['file' => 'uppercase.png',     'name' => 'Uppercase', 'search' => 'Uppercase'],
  ['file' => 'snitch.png',        'name' => 'Snitch', 'search' => 'Snitch'],
  ['file' => 'lancer-shoes.png',  'name' => 'Lancer Shoes', 'search' => 'Lancer'],
  ['file' => 'egoss.png',         'name' => 'Egoss', 'search' => 'Egoss'],
  ['file' => 'depo.png',          'name' => 'Depo', 'search' => 'Depo'],
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
          <a class="brand-tile" href="pages/filter-products?search=<?= urlencode($brand['search']) ?>&amp;brand=<?= urlencode($brand['name']) ?>" title="<?= $brand['name'] ?> products"<?= $isClone ? ' aria-hidden="true" tabindex="-1"' : '' ?>>
            <img src="uploads/brands/<?= $brand['file'] ?>" alt="<?= $isClone ? '' : $brand['name'] ?>" loading="lazy" width="600" height="300">
          </a>
        <?php endforeach; ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>
