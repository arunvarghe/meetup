// import jquery, popper and bootstrap globally, since it is used in many places
import $ from 'jquery';
global.$ = global.jquery = global.jQuery = $;
import bsCustomFileInput from 'bs-custom-file-input';

$(document).ready(function () {
    bsCustomFileInput.init()
});