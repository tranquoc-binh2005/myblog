// var config = {
//     language: 'vi',
//     skin: 'jquery-mobile',
//     uploadUrl: BASE_URL + '/serve/assets/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
//     basePath: BASE_URL + '/userfiles/',
//     authentication: function() {
//         return true;
//     }
// };
// CKFinder.define(config);
/*
 Copyright (c) 2007-2024, CKSource Holding sp. z o.o. All rights reserved.
 For licensing, see LICENSE.html or https://ckeditor.com/sales/license/ckfinder
 */

 var config = {};

 CKFinder.editorConfig = function( config ) {
     config.filebrowserBrowseUrl = BASE_URL + '/userfiles';
     config.filebrowserImageBrowseUrl = BASE_URL + '/userfiles/images';
     config.filebrowserFlashBrowseUrl = BASE_URL + '/userfiles/flash';
     config.filebrowserUploadUrl = BASE_URL + '/userfiles/upload';
     config.filebrowserImageUploadUrl = BASE_URL + '/userfiles/upload/images';
     config.filebrowserFlashUploadUrl = BASE_URL + '/userfiles/upload/flash';
 
     // Add any additional configuration settings here.
 };
 
 CKFinder.define( config );