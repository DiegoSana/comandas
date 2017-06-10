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


<div>
        <form action="./dummy.html" class="dropzone well" id="dropzone">
                <div class="fallback">
                        <input name="file" type="file" multiple="" />
                </div>
        </form>
</div>

<div id="preview-template" class="hide">
        <div class="dz-preview dz-file-preview">
                <div class="dz-image">
                        <img data-dz-thumbnail="" />
                </div>

                <div class="dz-details">
                        <div class="dz-size">
                                <span data-dz-size=""></span>
                        </div>

                        <div class="dz-filename">
                                <span data-dz-name=""></span>
                        </div>
                </div>

                <div class="dz-progress">
                        <span class="dz-upload" data-dz-uploadprogress=""></span>
                </div>

                <div class="dz-error-message">
                        <span data-dz-errormessage=""></span>
                </div>

                <div class="dz-success-mark">
                        <span class="fa-stack fa-lg bigger-150">
                                <i class="fa fa-circle fa-stack-2x white"></i>

                                <i class="fa fa-check fa-stack-1x fa-inverse green"></i>
                        </span>
                </div>

                <div class="dz-error-mark">
                        <span class="fa-stack fa-lg bigger-150">
                                <i class="fa fa-circle fa-stack-2x white"></i>

                                <i class="fa fa-remove fa-stack-1x fa-inverse red"></i>
                        </span>
                </div>
        </div>
</div><!-- PAGE CONTENT ENDS -->
                                                                

<!-- inline scripts related to this page -->
<script type="text/javascript">
    jQuery(function($){

    try {
        Dropzone.autoDiscover = false;

        var myDropzone = new Dropzone('#dropzone', {
            previewTemplate: $('#preview-template').html(),

            thumbnailHeight: 120,
            thumbnailWidth: 120,
            maxFilesize: 0.5,

            addRemoveLinks : true,
            dictRemoveFile: 'Eliminar',

            dictDefaultMessage :
            '<span class="bigger-150 bolder"><i class="ace-icon fa fa-caret-right red"></i> Arrastra los archivos</span> para subirlos \
            <span class="smaller-80 grey">(o hacé click acá)</span> <br /> \
            <i class="upload-icon ace-icon fa fa-cloud-upload blue fa-3x"></i>',

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
            }

        });


        //simulating upload progress
        var minSteps = 6,
        maxSteps = 60,
        timeBetweenSteps = 100,
        bytesPerStep = 100000;

        myDropzone.uploadFiles = function(files) {
            var self = this;

            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                    totalSteps = Math.round(Math.min(maxSteps, Math.max(minSteps, file.size / bytesPerStep)));

                for (var step = 0; step < totalSteps; step++) {
                    var duration = timeBetweenSteps * (step + 1);
                    setTimeout(function(file, totalSteps, step) {
                        return function() {
                            file.upload = {
                                progress: 100 * (step + 1) / totalSteps,
                                total: file.size,
                                bytesSent: (step + 1) * file.size / totalSteps
                            };

                            self.emit('uploadprogress', file, file.upload.progress, file.upload.bytesSent);
                            if (file.upload.progress == 100) {
                                file.status = Dropzone.SUCCESS;
                                self.emit("success", file, 'success', null);
                                self.emit("complete", file);
                                self.processQueue();
                            }
                        };
                    }(file, totalSteps, step), duration);
                }
            }
        }


        //remove dropzone instance when leaving this page in ajax mode
        $(document).one('ajaxloadstart.page', function(e) {
                        try {
                                myDropzone.destroy();
                        } catch(e) {}
        });

    } catch(e) {
        alert('Dropzone.js does not support older browsers!');
    }

    });
</script>                                                                