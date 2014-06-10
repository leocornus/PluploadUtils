<?php
/**
 * Template Name: plupload testing page 
 *
 * This is a page template for testing plupload on WordPress and 
 * MediaWiki integrated Web site.
 * We assume that MediaWiki is installed under foler wiki
 */

get_header();

// inqueue plupload lib
wp_enqueue_script('plupload-handlers');
?>

<script type="text/javascript">
// Custom example logic
jQuery(document).ready(function() { 
  var uploader = new plupload.Uploader({

      runtimes : 'html5,flash,silverlight,html4',
      unique_names : true,
      browse_button : 'pickfiles', // you can pass in id...
      container: 'container', // ... or DOM Element itself

      //url : "/plupload.php",
      url : "/wiki/Special:SpecialPlupload",
      multipart_params : {
          desc : "testing upload from ticket",
          comment : "from code, plupload"
      },

      filters : {
          max_file_size : '10mb',
          mime_types: [
              {title : "Image files", extensions : "jpg,gif,png"},
              {title : "Zip files", extensions : "zip"}
          ]
      },

      // set the file data name, MediaWiki class is using this
      // input id to get uploaded file data:
      file_data_name : 'wpUploadFile',
      // Flash settings
      flash_swf_url : '/wp-includes/js/plupload/plupload.flash.swf',
      // Silverlight settings
      silverlight_xap_url : '/wp-includes/js/plupload/plupload.sliverlight.swf',

      init: { 
          PostInit: function() {
              jQuery('filelist').innerHTML = '';
   
              jQuery('uploadfiles').onclick = function() {
                  uploader.start();
                  return false;
              };
          },

          FilesAdded: function(up, files) {
              plupload.each(files, function(file) {
                  document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
              });
          },
   
          UploadProgress: function(up, file) {
              document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
          },
   
          Error: function(up, err) {
              document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
          },
          
          // callback if file uploaded successfully.
          FileUploaded: function(up, file, info) {
              console.log("info: %O", info);
          }
      }
  });

  uploader.init();
  jQuery('#filelist').html('');
  jQuery('#uploadfiles').click(function() {
      uploader.start();
      return false;
  });
});
</script>
<div id="content">

  <div id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
  <br />
   
  <div id="container" style="">
      <a id="pickfiles" href="javascript:;">[Select files]</a>
      <a id="uploadfiles" href="javascript:;">[Upload files]</a>
  </div>
   
  <br />
  <pre id="console"></pre>
</div>

<?php
get_footer();
