<style>
.uk-modal-json .uk-modal-dialog {
  height: 85%;
}
.button-update {
  float: right;
}
</style>

<div class="uk-margin" if="{data}">
    <label class="uk-text-small">@lang('Devel')</label>
    <div class="uk-margin-small-top">
    <a onclick="{ showEntryJson }" class="extrafields-indicator uk-text-nowrap">
      <i class="uk-icon-code uk-icon-justify"></i>@lang('JSON Data')
    </div>
</div>

<div class="uk-modal uk-modal-json uk-height-viewport">
  <div class="uk-modal-dialog uk-modal-dialog-large">
    <a href="" class="uk-modal-close uk-close"></a>
    <strong>@lang('JSON Preview')</strong>
    @hasaccess?('helpers', 'jsonedit')
    <button onclick="{updateData}" class="button-update uk-button uk-button-small uk-button-secondary uk-margin-right">
      <i class="uk-icon-save"></i> @lang('Update')</button>
    @end
    <div class="uk-margin uk-flex uk-flex-middle" if="{data}">
      <codemirror ref="codemirrorjson" syntax="json"></codemirror>
    </div>
  </div>
</div>


<script>
  var $this = this;

  this.editAccess = {{ json_encode($editAccess) }};

  this.on('mount', function() {
    $this.modal = UIkit.modal(App.$('.uk-modal-json', this.root), {modal:true});
    $this.update();
  });

  this.showEntryJson = function() {
    $this.modal.show();
    editor = $this.refs.codemirrorjson.editor;
    editor.setValue(JSON.stringify($this.data, null, 2), true);
    editor.setOption("readOnly", !$this.editAccess);
    editor.setSize($this.modal.dialog[0].clientWidth - 50, $this.modal.dialog[0].clientHeight - 70);
    editor.refresh();
    $this.trigger('ready');
  }

  this.updateData = function(e) {
    editor = $this.refs.codemirrorjson.editor;
    try {
      json = JSON.parse(editor.getValue());
      $this.data = json;
      $this.modal.hide();
      App.ui.notify(App.i18n.get("Singleton structure updated! Save to persist changes."));
      $this.update();
    } catch(e) {
      App.ui.notify(App.i18n.get("Cannot update! Invalid json structure"), "danger");
      return;
    }
  }

</script>
