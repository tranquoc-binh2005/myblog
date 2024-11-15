var config = {
    language: 'vi',
    skin: 'jquery-mobile',
    uploadUrl: BASE_URL + '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
    basePath: BASE_URL + '/userfiles/',
    authentication: function() {
        return true;
    }
};
CKFinder.define(config);
