<?php

$app->on('admin.init', function () {
  // disable time widget in dashboard
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
});
