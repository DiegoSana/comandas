<?php
$this->breadcrumbs=array(
	'Productos Imagenes',
);
if($producotsImagenes) {
    foreach ($producotsImagenes as $productoImagen)
        $arr[] = array('name'=>$productoImagen->nombre,'size'=>1250,'type'=>'image/jpeg','serverId'=>$productoImagen->id);
    $data = json_encode($arr);
}
else
    $data = json_encode(array());
?>


<div class="row">
    <div class="files col-xs-12 dz-clickable">
        <div class="dropzone" id="up">
            <div class="dz-default dz-message" id="up">
                <span><span class="bigger-150 bolder"><i class="ace-icon fa fa-caret-right red"></i> Suelte las imágenes aquí</span> para subirlas <span class="smaller-80 grey">(o haga click)</span> <br><i class="upload-icon ace-icon fa fa-cloud-upload blue fa-3x"></i></span>
            </div>
        </div>
    </div>
</div>
<div class="row" style="margin: 1em;">
    <div class="table table-striped" class="files col-xs-12" id="previews">
      <div id="template" class="file-row col-xs-2">
        <div>
            <span class="preview"><img data-dz-thumbnail /></span>
        </div>
        <div>
            <!--<b class="name" data-dz-name>--></b>&nbsp;(<span class="size" data-dz-size></span>)&nbsp;
            <strong class="error text-danger" data-dz-errormessage></strong>
            <strong class="success text-success"></strong>
        </div>
        <div>
            <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
              <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
            </div>
        </div>
        <div id="actions">
          <button class="btn btn-primary btn-mini start">
              <i class="glyphicon glyphicon-upload"></i>
              <span>Subir</span>
          </button>
          <button data-dz-remove class="btn btn-danger btn-mini delete">
            <i class="glyphicon glyphicon-trash"></i>
            <span>Eliminar</span>
          </button>
        </div>
      </div>
    </div>
</div>

<style>
    .preview img{
        max-height: 90px;
    }
</style>

<script type="text/javascript">
$( document ).ready(function() {

    // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
    var previewNode = document.querySelector("#template");
    previewNode.id = "";
    var previewTemplate = previewNode.parentNode.innerHTML;
    previewNode.parentNode.removeChild(previewNode);

    var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
        url: "<?php echo Yii::app()->createAbsoluteUrl('/productosImagenes/upload')?>", // Set the url
        createImageThumbnails: true,
        thumbnailWidth: 10,
        thumbnailHeight: 10,
        parallelUploads: 20,
        previewTemplate: previewTemplate,
        autoQueue: false, // Make sure the files aren't queued until manually added
        previewsContainer: "#previews", // Define the container to display the previews
        clickable: "#up", // Define the element that should be used as click trigger to select files.
        thumbnail: function(file, dataUrl) {
            if (file.previewElement) {
              $(file.previewElement).removeClass("dz-file-preview");
              var images = $(file.previewElement).find("[data-dz-thumbnail]").each(function() {
                              var thumbnailElement = this;
                              thumbnailElement.alt = file.name;
                              thumbnailElement.src = dataUrl;
                      });
              setTimeout(function() { $(file.previewElement).addClass("dz-image-preview"); }, 1);
            }
        },
        uploadprogress: function(file, progress, bytesSent) {
            file.previewElement.querySelector("#total-progress .progress-bar").style.width = progress + "%";
        },
        init: function () {
            var obj = this;
            var mockFile = <?php echo $data;?>;
            $.each(mockFile, function(k,v){            
                obj.addFile.call(obj, v);
                obj.options.thumbnail.call(obj, v, "/images/productos/"+v.name);
                obj.files[k].previewElement.querySelector(".start").setAttribute("disabled", "disabled");
                obj.files[k].previewElement.querySelector("#total-progress").style.opacity = "0";
                obj.files[k].previewElement.querySelector(".success").innerHTML = '<i class="ace-icon fa fa-check bigger-110 green"></i>Subida';
            });
            this.on("removedfile", function(file) {
                if (!file.serverId) { return; } // The file hasn't been uploaded
                $.post("<?php echo Yii::app()->createAbsoluteUrl('/productosImagenes/delete');?>/"+file.serverId).done(function(msg){alert(msg)}); // Send the file id along
            });
        }
    });

    myDropzone.on("addedfile", function(file) {
      // Hookup the start button
      file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
    });

    myDropzone.on("sending", function(file) {
      // Show the total progress bar when upload starts
      file.previewElement.querySelector("#total-progress").style.opacity = "1";
      // And disable the start button
      file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
    });

    myDropzone.on("success", function(file,response) {    
        if(response==='OK')
        {
            file.previewElement.querySelector(".success").innerHTML = '<i class="ace-icon fa fa-check bigger-110 green"></i>Subida';
            file.previewElement.querySelector("#total-progress").style.opacity = "0";
        }
        else
            file.previewElement.querySelector(".error").innerHTML = '<i class="ace-icon fa fa-times bigger-110 red"></i>Se produjo un error';          
    });

    // Setup the buttons for all transfers
    // The "add files" button doesn't need to be setup because the config
    // `clickable` has already been specified.
    /*document.querySelector("#actions .start").onclick = function() {
      myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
    };
    document.querySelector("#actions .cancel").onclick = function() {
      myDropzone.removeAllFiles(true);
    };*/


});
</script>
