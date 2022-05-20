<link rel="stylesheet" href="{{asset('css/dropzone.min.css')}}">
<div class="form-horizontal">
    <div class="box-body">
        <div class="form-group">
            <label class="{{ $label_class }} control-label" style="font-weight: bold; margin-bottom: 10px">@lang('admin.Upload images')</label>
            <div class="dropzone {{ $dropzone_class }}" id="imageUpload">
                <div class="dz-preview dz-file-preview">
                    <div class="dz-success-mark"><span>✔</span></div>
                    <div class="dz-error-message"><span data-dz-errormessage></span></div>
                </div>
            </div>
        </div>
        <div class="form-group" id="images_list"></div>
    </div>
</div>
<script src="{{asset('js/dropzone.min.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="//cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('js/admin/fslightbox.js') }}"></script>
<script>
    "use strict";
    let page = 1;
    let counter=0;
    let selectedImages = [];
    let layout = document.createElement('div');
    let container = document.getElementById('images_list');
    const fireToast = (icon, text) => {
        Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
        }).fire({
            icon: icon,
            title: text
        });
    };
    function setLayout(html, cssClass=null){
        layout.className = '';
        if(cssClass) {
            let classes = cssClass.split(' ');
            for(let i=0; i<classes.length; i++) layout.classList.add(classes[i]);
        }
        layout.innerHTML = html;
    }
    function reselectImages(){
        counter=0;
        selectedImages.map((imgID) => {
            let imgDOM = container.querySelector(`img[id="${imgID}"]`);
            if(imgDOM instanceof Element) changeSelectedImages(imgDOM, 'add', false);
            else changeSelectedImages(imgID, 'add', false);
        });
    }
    document.addEventListener('click', (event) => {
        let element = event.target;
        if(element.nodeName === "SPAN" && element.parentElement && element.parentElement.classList.contains('clickable')){
            page = element.parentElement.dataset.page;
            getImages();
        }
    });
    Dropzone.autoDiscover = false;
    const imagesUploadDropzone = new Dropzone("div#imageUpload", {
        url: '{{ route('admin.media.images.store') }}',
        paramName: "file",
        maxFilesize: 50,
        addRemoveLinks: true,
        acceptedFiles: 'image/*',
        dictInvalidFileType: '@lang("admin.You can only post pictures!")',
        dictFileTooBig: '@lang("admin.Your image is too large!")',
        dictDefaultMessage: '@lang("admin.Drag files here")',
        method: "POST",
        timeout: 0,
        headers: {
            'x-csrf-token': document.querySelector('meta[name="csrf-token"]').getAttributeNode('content').value,
        },
        init: function() {
            const _this = this;
            this.on("success", function(file) {
                fireToast('success', '@lang("admin.Image was successfully uploaded.")');
                file.previewElement.remove();
                document.querySelector('#imageUpload').classList.remove('dz-started');
                getImages();
            });
        },
    });
    function getImages(resetPage = false){
        axios.get('{{ route('admin.media.images.get_images') }}', {
            params: {
                'page': resetPage ? 1 : page,
                'label_class': '{{ $label_class }}',
            }
        }).then(({data}) => {
            document.querySelector('#images_list').innerHTML = data.html;
            reselectImages();
            refreshFsLightbox();
            if(data.page !== page) page = data.page;
        }, () => fireToast('error', '@lang("admin.Images could not be loaded.")'));
    }
    function deleteImage(id){
        Swal.fire({
            title: "@lang('admin.Are you sure')",
            text: "@lang('admin.Do you want to delete this image')?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "@lang('admin.Yes, delete')",
            cancelButtonText: "@lang('admin.No, cancel')"
        }).then((result) => {
            if (result.value) {
                axios.get(`/admin/media/images/destroy/${id}`)
                    .then(() => {
                        fireToast('success', '@lang("admin.Image successfully deleted.")');
                        getImages();
                    }, () => fireToast('error', '@lang("admin.Image could not be deleted.")'));
            }
        })
    }
    function allowClick(numberOfImages = 0) {
        container = refreshEventListener(container);
        container.addEventListener('click', (e) => {
            if(e.target.classList.contains('mediaGalleryImage')){
                let clickedImg = e.target;
                if(numberOfImages === 0) return false;
                if(counter === numberOfImages){
                    if(selectedImages.includes(clickedImg.id)){
                        let imgDOM = container.querySelector(`img[id="${clickedImg.id}"]`);
                        imgDOM ? changeSelectedImages(imgDOM, 'remove') : changeSelectedImages(clickedImg.id, 'remove');
                    }
                    else{
                        let imgDOM = container.querySelector(`img[id="${selectedImages[0]}"]`);
                        imgDOM ? changeSelectedImages(imgDOM, 'remove') : changeSelectedImages(selectedImages[0], 'remove');
                        changeSelectedImages(clickedImg, 'add');
                    }
                }
                else selectedImages.includes(clickedImg.id) ? changeSelectedImages(clickedImg, 'remove') : changeSelectedImages(clickedImg, 'add');

                document.querySelector('#addImageButton').disabled = selectedImages.length === 0;
            }
        });
    }
    function changeSelectedImages(img, action, modifyArray = true) {
        if(action === "add"){
            if(img instanceof Element){
                img.classList.add('selected');
                img.parentElement.style.margin = '-2px -2px 8px 8px';
                modifyArray ? selectedImages.push(img.id) : null;
            }
            else modifyArray ? selectedImages.push(img) : null;
            counter++;
        }
        else if(action === "remove"){
            if(img instanceof Element){
                img.classList.remove('selected');
                img.parentElement.style.margin = '0 0 10px 10px';
                modifyArray ? selectedImages = selectedImages.filter((id) => id !== img.id) : null;
            }
            else modifyArray ? selectedImages = selectedImages.filter((id) => id !== img) : null;
            counter--;
        }

        if(counter<0) counter = 0;
    }
    function refreshEventListener(oldElement) {
        const newElement = oldElement.cloneNode(true);
        oldElement.parentNode.replaceChild(newElement, oldElement);

        return newElement;
    }
    function save({className, id, type, htmlID=type, numberOfImages=1, dimension="m", remove=false}, callback = () => {}){
        axios.post('{{ route('admin.media.model_images.store') }}', {
            headers: {
                'x-csrf-token': document.querySelector('meta[name="csrf-token"]').getAttributeNode('content').value,
            },
            data: {
                'images': selectedImages,
                'class_name': className,
                'type': type,
                'model_id': id,
                'number_of_images': numberOfImages,
                'dimension': dimension
            }
        }).then(({data}) => {
            let parentElement = document.getElementById(htmlID);
            numberOfImages === 1 ? parentElement.innerHTML = "" : null;
            for(let i=0; i<data.images.length; i++){
                let childElement = layout.cloneNode(true);
                childElement.querySelector('img').src=data.images[i].src;
                childElement.querySelector('img').dataset['imageGalleryId'] = data.images[i].id;

                let previewHref = document.createElement('a');
                previewHref.classList.add('preview-button');
                previewHref.dataset.fslightbox = `lightbox-${type}`;
                previewHref.href = data.images[i].largeSrc;
                let previewButton = document.createElement('button');
                previewButton.classList.add('btn', 'btn-info', 'btn-md');
                previewButton.type = 'button';
                previewButton.innerHTML = '<i class="fa fa-search"></i>';
                previewHref.appendChild(previewButton);

                let deleteButton = document.createElement('button');
                deleteButton.classList.add('btn', 'btn-danger', 'delete-button', 'btn-md');
                deleteButton.innerHTML = '<i class="fa fa-trash"></i>';
                deleteButton.type = 'button';
                deleteButton.addEventListener('click', () => deleteModelImage(data.images[i].id, remove));

                childElement.appendChild(deleteButton);
                childElement.appendChild(previewHref);

                parentElement.appendChild(childElement);
            }
            callback();
            [...selectedImages].map((imgID) => {
                let imgDOM = container.querySelector(`img[id="${imgID}"]`);
                if(imgDOM instanceof Element) changeSelectedImages(imgDOM, 'remove', false);
            });
            selectedImages = [];
            counter=0;
            refreshFsLightbox();
        }, () => fireToast('error', '@lang("admin.Images could not be added.")'));
    }
    function deleteModelImage(id, remove){
        axios.get('{{ route('admin.media.model_images.destroy') }}', {
            params: {id}
        }).then(() => {
            let modelImage = document.querySelector(`img[data-image-gallery-id='${id}']`);
            if(remove) modelImage.parentElement.remove();
            else {
                modelImage.src = "{{ asset('files/imagePlaceholder.png') }}";
                modelImage.dataset['imageGalleryId'] = '';
                modelImage.parentElement.querySelector('.delete-button').remove();
                modelImage.parentElement.querySelector('.preview-button').remove();
            }
            fireToast('success', '@lang("admin.Image successfully removed.")');
        }, () => fireToast('error', '@lang("admin.Images could not be removed.")'));
    }
    function setImagesOnCreateForm({type, htmlID=type, numberOfImages, dimension, remove}, callback = () => {}){
        axios.get('{{ route('admin.media.images.load') }}',{
            params: {
                'images': selectedImages,
                'type': htmlID,
                'dimension': dimension
            }
        }).then(({data}) => {
            let parentElement = document.getElementById(htmlID);
            numberOfImages === 1 ? parentElement.innerHTML = "" : null;
            if(data.images.length === 1){
                let childElement = layout.cloneNode(true);
                childElement.querySelector('img').src=data.images[0].src;
                childElement.querySelector('img').dataset['imageGalleryId'] = data.images[0].id;
                document.querySelector('#featured_image').value = data.images[0].id;
                parentElement.appendChild(childElement);
            }
            callback();
            [...selectedImages].map((imgID) => {
                let imgDOM = container.querySelector(`img[id="${imgID}"]`);
                if(imgDOM instanceof Element) changeSelectedImages(imgDOM, 'remove', false);
            });
            selectedImages = [];
            counter=0;
            refreshFsLightbox();
        }, () => fireToast('error', '@lang("admin.Images could not be added.")'));
    }
</script>
