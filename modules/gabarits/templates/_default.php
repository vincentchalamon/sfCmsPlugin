<?php use_javascript('http://connect.facebook.net/fr_FR/all.js#xfbml=1') ?>
<?php use_javascript('http://platform.twitter.com/widgets.js') ?>

<?php if($sf_data->getRaw('menu')): ?>
  <ul id="breadcrumb">
    <li><?php echo __('You are here', array(), 'sf_cms') ?> :</li>
    <?php foreach(getBreadcrumb($sf_data->getRaw('menu')) as $element): ?>
      <li><?php echo link_to($element, $element->getRoute(), array('title' => $element)) ?> &gt;</li>
    <?php endforeach ?>
    <li><?php echo $sf_data->getRaw('menu') ?></li>
  </ul>
<?php endif ?>

<h1><?php echo $sf_data->getRaw('page')->getTitle() ?></h1>
<p class="chapo"><?php echo format_date(strtotime($sf_data->getRaw('page')->getUpdatedAt()), "EEEE dd MMMM yyyy", $sf_user->getCulture()) ?></p>
<?php echo $sf_data->getRaw('page')->getContents() ?>

<?php if(!$sf_data->getRaw('page')->getRequireAuth()): ?>
  <fb:like send="true" layout="button_count" show_faces="false"></fb:like>
  <a href="https://twitter.com/share" class="twitter-share-button" data-lang="fr">Tweeter</a>
<?php endif ?>