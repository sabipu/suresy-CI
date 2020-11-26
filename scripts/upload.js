var Upload = function (file) {
    this.file = file;
    this.url = '/claims/make/upload';
    this.success = function (data){
    
    };
    this.error = function (error){
    
    };
};

Upload.prototype.getType = function() {
    return this.file.type;
};
Upload.prototype.getSize = function() {
    return this.file.size;
};
Upload.prototype.getName = function() {
    return this.file.name;
};
Upload.prototype.doUpload = function (otherData) {
    var that = this;
    var formData = new FormData();

    
    // add assoc key values, this will be posts values
    formData.append("file", this.file, this.getName());
    formData.append("upload_file", true);
    
    if(typeof otherData != 'undefined')
    {
      for(var key in otherData)
      {
        formData.append(key, otherData[key]);
      }
    }

    $.ajax({
        type: "POST",
        url: that.url,
        xhr: function () {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
                myXhr.upload.addEventListener('progress', that.progressHandling, false);
            }
            return myXhr;
        },
        success: function (data) {
            // your callback here
            that.success(data);
        },
        error: function (error) {
            // handle error
            that.error(data);

        },
        async: true,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        timeout: 60000,
        dataType:'json'
    });
};

Upload.prototype.progressHandling = function (event) {
    var percent = 0;
    var position = event.loaded || event.position;
    var total = event.total;
    var progress_bar_id = "#progress-wrp";
    if (event.lengthComputable) {
        percent = Math.ceil(position / total * 100);
    }
    // update progressbars classes so it fits your code
    $(progress_bar_id + " .progress-bar").css("width", +percent + "%");
    $(progress_bar_id + " .status").text(percent + "%");
};