<?php use_stylesheet('/sfEPFactoryFormPlugin/switcher/js-switcher.css') ?>
<?php use_javascript('/sfEPFactoryFormPlugin/js/jquery.min.js', 'first') ?>
<?php use_javascript('/sfEPFactoryFormPlugin/switcher/switcher.js') ?>

<style type="text/css">
    .sf_admin_form_field_image_path {
        position: relative;
        margin-bottom: 10px;
    }
    .sf_admin_form_field_image_path .uploadifyQueue {
        position: absolute;
        right: 0;
        top: 15px;
    }
    .sf_admin_form_field_target {
        float: left;
        width: 40%;
        padding-top: 2px;
        margin-bottom: 10px;
    }
    .sf_admin_form_field_url, .sf_admin_form_field_article_id {
        float: right;
        clear: none !important;
        width: 55%;
        position: relative;
    }
    .sf_admin_form_field_url .smltxt, .sf_admin_form_field_article_id .smltxt {
        position: absolute;
        bottom: -15px;
    }
    .sf_admin_form_field_url .smltxt.red, .sf_admin_form_field_article_id .smltxt.red {
        bottom: -40px;
    }
    .sf_admin_form_field_url label, .sf_admin_form_field_article_id label {
        display: none !important;
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){
        $('.sf_admin_form_field_target input').live('change', function(){
            $('.sf_admin_form_field_url, .sf_admin_form_field_article_id').hide();
            $('.sf_admin_form_field_' + $(this).val()).show();
        }).siblings(':checked').trigger('change');
    });
</script>

<div class="sf_admin_form_row sf_admin_enum sf_admin_form_field_target">
    <span class="switch">
        <input type="radio" name="sf_admin_form_field_target" id="sf_admin_form_field_target_url" value="url"<?php if (!$form['article_id']->hasError() && (!$form->getObject()->getArticleId() || $form['url']->hasError())): ?> checked="checked"<?php endif ?> autocomplete="off" class="noTransform" />
        <input type="radio" name="sf_admin_form_field_target" id="sf_admin_form_field_target_article_id" value="article_id"<?php if (!$form['url']->hasError() && ($form->getObject()->getArticleId() || $form['article_id']->hasError())): ?> checked="checked"<?php endif ?> autocomplete="off" class="noTransform" />
        <label for="sf_admin_form_field_target_url" class="cb-enable<?php if (!$form['article_id']->hasError() && (!$form->getObject()->getArticleId() || $form['url']->hasError())): ?> selected<?php endif ?>"><span>Définir une url</span></label>
        <label for="sf_admin_form_field_target_article_id" class="cb-disable<?php if (!$form['url']->hasError() && ($form->getObject()->getArticleId() || $form['article_id']->hasError())): ?> selected<?php endif ?>"><span>Lier à un article</span></label>
    </span>
</div>