window._ = require('lodash');

try {
    window.$ = window.jQuery = require('jquery');
    window.Popper = require('@popperjs/core');
    window.bootstrap = require('bootstrap');
} catch (exception) {
    console.error(exception);
}

require('./bootstrap');
