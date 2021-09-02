try {
    window.$ = window.jQuery = require('jquery');
    require('admin-lte');
    require('admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js');
    window.toastr = require('admin-lte/plugins/toastr/toastr.min.js');
} catch (e) {}
