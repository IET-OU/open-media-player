/* Was in: mep-oup-feature-shim.js
*/
$.log = function (s) {
    if (typeof console === 'object' && $.oup_debug) {
        console.log(arguments.length === 1 ? s : arguments);
    }
}
