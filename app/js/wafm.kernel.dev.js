const WAFM = new function () {
    /**
     * @param {string} index
     * @param {string} request
     * @returns {*}
     */
    var xurl = function (index, request) {
        return {
            module: "module/" + request,
            json: "json/" + request,
        }[index];
    };
    /**
     *
     * @param type
     * @param request
     * @param selector
     * @param data
     * @param async
     * @returns mixed
     * */
    this.request = function (type, request, selector, data, async) {
        var url = xurl(type, request);
        if (type === 'module') {
            return $.ajax(url, {
                type: "GET",
                data: data,
                async: async,
                complete: function (response) {
                    $(selector).html(response.responseText);
                }
            });
        } else if (type === 'json') {
            return $.ajax(url, {
                type: "GET",
                data: data,
                async: async,
                complete: function (response) {
                    $(selector).html(response.responseJSON);
                }
            });
        }
    };
    /**
     * @param {string} type
     * @param {string} request
     * @returns {string|null|*}
     */
    this.include = function (type, request) {
        var url = xurl(type, request);
        if (type === 'module') {
            return $.ajax(url, {
                type: "GET",
                data: {},
                async: false,
                fail: function () {
                }
            }).responseText;
        } else if (type === 'json') {
            return $.ajax(url, {
                type: "GET",
                data: {},
                async: false,
                fail: function () {
                }
            }).responseJSON;
        }
        return null;
    };
    this.fn = {};
    this.kernel = {};
};

(function ($) {
    /**
     *
     * @param {string} separator
     * @param {array} value
     * @returns {string}
     */
    $.implode = function (separator, value) {
        return value.join(separator);
    };
    /**
     * @param {mixed} value
     * @returns {boolean}
     */
    $.empty = function (value) {
        return [undefined, null, 0, 0.0, "", "\0"].indexOf(value) >= 0;
    };
    /**
     * @param {array|object} value
     */
    $.debug = function (value) {
        if (typeof value == "object") {
            var result = '<div style="background: black; color: white;">';
            for (var e in value) {
                result += '<div>' + e + ': ' + value[e] + '</div>';
            }
            result += '</div>';
            $('body').text('').html(result);
        }
    };
    kernel = $;
})(WAFM.kernel);

/**
 * @param {string} module
 * @param {string} file
 * @param {bool|undefined|null} write
 * @returns {string|null|*}
 */
const include = function (module, file, write) {
    var result = WAFM.include(module, file);
    if (kernel.empty(write)) {
        return result;
    } else {
        document.write(result);
    }
};

/**
 * @param {string} type
 * @param {string} request
 * @param {string} selector
 * @param {json} data
 * @param {bool} async
 */
const request = function (type, request, selector, data, async) {
    WAFM.request(type, request, selector, data, async);
}


