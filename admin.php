<?php

$app->on('admin.init', function () {
  // Disable time widget in dashboard.
  $this->on('admin.dashboard.widgets', function($widgets) {
    foreach($widgets as $key => $widget) {
      if ($widget['name'] == 'time') {
        unset($widgets[$key]);
        break;
      }
    }
  }, 0);

  // Set default group in entry view to "Main" (default: "All")
  // When the page loads, `this.group` is an empty string. After the first
  // call of `toggleGroup()` it is 'GroupName' or false.
  $this->on('collections.entry.aside', function() {
    echo '<span if="{ group === \'\' && !(group = \'Main\') }" class="">test</span>';
  });

  // Add assets to modules menu.
  $this('admin')->addMenuItem('modules', [
    'label' => 'Assets',
    'icon' => 'assets:app/media/icons/assets.svg',
    'route' => '/assetsmanager',
    'active' => strpos($this['route'], '/assetsmanager') === 0,
  ]);

  // Add JSON view to collections.
  $this->on('collections.entry.aside', function () use ($app) {
    $this->renderView("cockpitutils:views/partials/json-entry-aside.php");
  });

  // Add JSON view to singletons.
  $this->on('singletons.form.aside', function () use ($app) {
    $this->renderView("cockpitutils:views/partials/json-singleton-entry-aside.php");
  });
});
