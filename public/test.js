/**
 * @file
 * Drupal Bootstrap object.
 */

/**
 * All Drupal Bootstrap JavaScript APIs are contained in this namespace.
 *
 * @param {underscore} _
 * @param {jQuery} $
 * @param {Drupal} Drupal
 * @param {drupalSettings} drupalSettings
 */
(function (_, $, Drupal, drupalSettings) {
    'use strict';

    /**
     * @typedef Drupal.bootstrap
     */
    var Bootstrap = {
        processedOnce: {},
        settings: drupalSettings.bootstrap || {}
    };

    /**
     * Wraps Drupal.checkPlain() to ensure value passed isn't empty.
     *
     * Encodes special characters in a plain-text string for display as HTML.
     *
     * @param {string} str
     *   The string to be encoded.
     *
     * @return {string}
     *   The encoded string.
     *
     * @ingroup sanitization
     */
    Bootstrap.checkPlain = function (str) {
        return str && Drupal.checkPlain(str) || '';
    };

    /**
     * Creates a jQuery plugin.
     *
     * @param {String} id
     *   A jQuery plugin identifier located in $.fn.
     * @param {Function} plugin
     *   A constructor function used to initialize the for the jQuery plugin.
     * @param {Boolean} [noConflict]
     *   Flag indicating whether or not to create a ".noConflict()" helper method
     *   for the plugin.
     */
    Bootstrap.createPlugin = function (id, plugin, noConflict) {
        // Immediately return if plugin doesn't exist.
        if ($.fn[id] !== void 0) {
            return this.fatal('Specified jQuery plugin identifier already exists: @id. Use Drupal.bootstrap.replacePlugin() instead.', {'@id': id});
        }

        // Immediately return if plugin isn't a function.
        if (typeof plugin !== 'function') {
            return this.fatal('You must provide a constructor function to create a jQuery plugin "@id": @plugin', {'@id': id, '@plugin':  plugin});
        }

        // Add a ".noConflict()" helper method.
        this.pluginNoConflict(id, plugin, noConflict);

        $.fn[id] = plugin;
    };

    /**
     * Diff object properties.
     *
     * @param {...Object} objects
     *   Two or more objects. The first object will be used to return properties
     *   values.
     *
     * @return {Object}
     *   Returns the properties of the first passed object that are not present
     *   in all other passed objects.
     */
    Bootstrap.diffObjects = function (objects) {
        var args = Array.prototype.slice.call(arguments);
        return _.pick(args[0], _.difference.apply(_, _.map(args, function (obj) {
            return Object.keys(obj);
        })));
    };

    /**
     * Map of supported events by regular expression.
     *
     * @type {Object<Event|MouseEvent|KeyboardEvent|TouchEvent,RegExp>}
     */
    Bootstrap.eventMap = {
        Event: /^(?:load|unload|abort|error|select|change|submit|reset|focus|blur|resize|scroll)$/,
        MouseEvent: /^(?:click|dblclick|mouse(?:down|enter|leave|up|over|move|out))$/,
        KeyboardEvent: /^(?:key(?:down|press|up))$/,
        TouchEvent: /^(?:touch(?:start|end|move|cancel))$/
    };

    /**
     * Extends a jQuery Plugin.
     *
     * @param {String} id
     *   A jQuery plugin identifier located in $.fn.
     * @param {Function} callback
     *   A constructor function used to initialize the for the jQuery plugin.
     *
     * @return {Function|Boolean}
     *   The jQuery plugin constructor or FALSE if the plugin does not exist.
     */
    Bootstrap.extendPlugin = function (id, callback) {
        // Immediately return if plugin doesn't exist.
        if (typeof $.fn[id] !== 'function') {
            return this.fatal('Specified jQuery plugin identifier does not exist: @id', {'@id':  id});
        }

        // Immediately return if callback isn't a function.
        if (typeof callback !== 'function') {
            return this.fatal('You must provide a callback function to extend the jQuery plugin "@id": @callback', {'@id': id, '@callback':  callback});
        }

        // Determine existing plugin constructor.
        var constructor = $.fn[id] && $.fn[id].Constructor || $.fn[id];
        var plugin = callback.apply(constructor, [this.settings]);
        if (!$.isPlainObject(plugin)) {
            return this.fatal('Returned value from callback is not a plain object that can be used to extend the jQuery plugin "@id": @obj', {'@obj':  plugin});
        }

        this.wrapPluginConstructor(constructor, plugin, true);

        return $.fn[id];
    };

    Bootstrap.superWrapper = function (parent, fn) {
        return function () {
            var previousSuper = this.super;
            this.super = parent;
            var ret = fn.apply(this, arguments);
            if (previousSuper) {
                this.super = previousSuper;
            }
            else {
                delete this.super;
            }
            return ret;
        };
    };

    /**
     * Provide a helper method for displaying when something is went wrong.
     *
     * @param {String} message
     *   The message to display.
     * @param {Object} [args]
     *   An arguments to use in message.
     *
     * @return {Boolean}
     *   Always returns FALSE.
     */
    Bootstrap.fatal = function (message, args) {
        if (this.settings.dev && console.warn) {
            for (var name in args) {
                if (args.hasOwnProperty(name) && typeof args[name] === 'object') {
                    args[name] = JSON.stringify(args[name]);
                }
            }
            Drupal.throwError(new Error(Drupal.formatString(message, args)));
        }
        return false;
    };

    /**
     * Intersects object properties.
     *
     * @param {...Object} objects
     *   Two or more objects. The first object will be used to return properties
     *   values.
     *
     * @return {Object}
     *   Returns the properties of first passed object that intersects with all
     *   other passed objects.
     */
    Bootstrap.intersectObjects = function (objects) {
        var args = Array.prototype.slice.call(arguments);
        return _.pick(args[0], _.intersection.apply(_, _.map(args, function (obj) {
            return Object.keys(obj);
        })));
    };

    /**
     * Normalizes an object's values.
     *
     * @param {Object} obj
     *   The object to normalize.
     *
     * @return {Object}
     *   The normalized object.
     */
    Bootstrap.normalizeObject = function (obj) {
        if (!$.isPlainObject(obj)) {
            return obj;
        }

        for (var k in obj) {
            if (typeof obj[k] === 'string') {
                if (obj[k] === 'true') {
                    obj[k] = true;
                }
                else if (obj[k] === 'false') {
                    obj[k] = false;
                }
                else if (obj[k].match(/^[\d-.]$/)) {
                    obj[k] = parseFloat(obj[k]);
                }
            }
            else if ($.isPlainObject(obj[k])) {
                obj[k] = Bootstrap.normalizeObject(obj[k]);
            }
        }

        return obj;
    };

    /**
     * An object based once plugin (similar to jquery.once, but without the DOM).
     *
     * @param {String} id
     *   A unique identifier.
     * @param {Function} callback
     *   The callback to invoke if the identifier has not yet been seen.
     *
     * @return {Bootstrap}
     */
    Bootstrap.once = function (id, callback) {
        // Immediately return if identifier has already been processed.
        if (this.processedOnce[id]) {
            return this;
        }
        callback.call(this, this.settings);
        this.processedOnce[id] = true;
        return this;
    };

    /**
     * Provide jQuery UI like ability to get/set options for Bootstrap plugins.
     *
     * @param {string|object} key
     *   A string value of the option to set, can be dot like to a nested key.
     *   An object of key/value pairs.
     * @param {*} [value]
     *   (optional) A value to set for key.
     *
     * @returns {*}
     *   - Returns nothing if key is an object or both key and value parameters
     *   were provided to set an option.
     *   - Returns the a value for a specific setting if key was provided.
     *   - Returns an object of key/value pairs of all the options if no key or
     *   value parameter was provided.
     *
     * @see https://github.com/jquery/jquery-ui/blob/master/ui/widget.js
     */
    Bootstrap.option = function (key, value) {
        var options = $.isPlainObject(key) ? $.extend({}, key) : {};

        // Get all options (clone so it doesn't reference the internal object).
        if (arguments.length === 0) {
            return $.extend({}, this.options);
        }

        // Get/set single option.
        if (typeof key === "string") {
            // Handle nested keys in dot notation.
            // e.g., "foo.bar" => { foo: { bar: true } }
            var parts = key.split('.');
            key = parts.shift();
            var obj = options;
            if (parts.length) {
                for (var i = 0; i < parts.length - 1; i++) {
                    obj[parts[i]] = obj[parts[i]] || {};
                    obj = obj[parts[i]];
                }
                key = parts.pop();
            }

            // Get.
            if (arguments.length === 1) {
                return obj[key] === void 0 ? null : obj[key];
            }

            // Set.
            obj[key] = value;
        }

        // Set multiple options.
        $.extend(true, this.options, options);
    };

    /**
     * Adds a ".noConflict()" helper method if needed.
     *
     * @param {String} id
     *   A jQuery plugin identifier located in $.fn.
     * @param {Function} plugin
     * @param {Function} plugin
     *   A constructor function used to initialize the for the jQuery plugin.
     * @param {Boolean} [noConflict]
     *   Flag indicating whether or not to create a ".noConflict()" helper method
     *   for the plugin.
     */
    Bootstrap.pluginNoConflict = function (id, plugin, noConflict) {
        if (plugin.noConflict === void 0 && (noConflict === void 0 || noConflict)) {
            var old = $.fn[id];
            plugin.noConflict = function () {
                $.fn[id] = old;
                return this;
            };
        }
    };

    /**
     * Creates a handler that relays to another event name.
     *
     * @param {HTMLElement|jQuery} target
     *   A target element.
     * @param {String} name
     *   The name of the event to trigger.
     * @param {Boolean} [stopPropagation=true]
     *   Flag indicating whether to stop the propagation of the event, defaults
     *   to true.
     *
     * @return {Function}
     *   An even handler callback function.
     */
    Bootstrap.relayEvent = function (target, name, stopPropagation) {
        return function (e) {
            if (stopPropagation === void 0 || stopPropagation) {
                e.stopPropagation();
            }
            var $target = $(target);
            var parts = name.split('.').filter(Boolean);
            var type = parts.shift();
            e.target = $target[0];
            e.currentTarget = $target[0];
            e.namespace = parts.join('.');
            e.type = type;
            $target.trigger(e);
        };
    };

    /**
     * Replaces a Bootstrap jQuery plugin definition.
     *
     * @param {String} id
     *   A jQuery plugin identifier located in $.fn.
     * @param {Function} callback
     *   A callback function that is immediately invoked and must return a
     *   function that will be used as the plugin constructor.
     * @param {Boolean} [noConflict]
     *   Flag indicating whether or not to create a ".noConflict()" helper method
     *   for the plugin.
     */
    Bootstrap.replacePlugin = function (id, callback, noConflict) {
        // Immediately return if plugin doesn't exist.
        if (typeof $.fn[id] !== 'function') {
            return this.fatal('Specified jQuery plugin identifier does not exist: @id', {'@id':  id});
        }

        // Immediately return if callback isn't a function.
        if (typeof callback !== 'function') {
            return this.fatal('You must provide a valid callback function to replace a jQuery plugin: @callback', {'@callback': callback});
        }

        // Determine existing plugin constructor.
        var constructor = $.fn[id] && $.fn[id].Constructor || $.fn[id];
        var plugin = callback.apply(constructor, [this.settings]);

        // Immediately return if plugin isn't a function.
        if (typeof plugin !== 'function') {
            return this.fatal('Returned value from callback is not a usable function to replace a jQuery plugin "@id": @plugin', {'@id': id, '@plugin': plugin});
        }

        this.wrapPluginConstructor(constructor, plugin);

        // Add a ".noConflict()" helper method.
        this.pluginNoConflict(id, plugin, noConflict);

        $.fn[id] = plugin;
    };

    /**
     * Simulates a native event on an element in the browser.
     *
     * Note: This is a fairly complete modern implementation. If things aren't
     * working quite the way you intend (in older browsers), you may wish to use
     * the jQuery.simulate plugin. If it's available, this method will defer to
     * that plugin.
     *
     * @see https://github.com/jquery/jquery-simulate
     *
     * @param {HTMLElement|jQuery} element
     *   A DOM element to dispatch event on. Note: this may be a jQuery object,
     *   however be aware that this will trigger the same event for each element
     *   inside the jQuery collection; use with caution.
     * @param {String|String[]} type
     *   The type(s) of event to simulate.
     * @param {Object} [options]
     *   An object of options to pass to the event constructor. Typically, if
     *   an event is being proxied, you should just pass the original event
     *   object here. This allows, if the browser supports it, to be a truly
     *   simulated event.
     *
     * @return {Boolean}
     *   The return value is false if event is cancelable and at least one of the
     *   event handlers which handled this event called Event.preventDefault().
     *   Otherwise it returns true.
     */
    Bootstrap.simulate = function (element, type, options) {
        // Handle jQuery object wrappers so it triggers on each element.
        var ret = true;
        if (element instanceof $) {
            element.each(function () {
                if (!Bootstrap.simulate(this, type, options)) {
                    ret = false;
                }
            });
            return ret;
        }

        if (!(element instanceof HTMLElement)) {
            this.fatal('Passed element must be an instance of HTMLElement, got "@type" instead.', {
                '@type': typeof element,
            });
        }

        // Defer to the jQuery.simulate plugin, if it's available.
        if (typeof $.simulate === 'function') {
            new $.simulate(element, type, options);
            return true;
        }

        var event;
        var ctor;
        var types = [].concat(type);
        for (var i = 0, l = types.length; i < l; i++) {
            type = types[i];
            for (var name in this.eventMap) {
                if (this.eventMap[name].test(type)) {
                    ctor = name;
                    break;
                }
            }
            if (!ctor) {
                throw new SyntaxError('Only rudimentary HTMLEvents, KeyboardEvents and MouseEvents are supported: ' + type);
            }
            var opts = {bubbles: true, cancelable: true};
            if (ctor === 'KeyboardEvent' || ctor === 'MouseEvent') {
                $.extend(opts, {ctrlKey: !1, altKey: !1, shiftKey: !1, metaKey: !1});
            }
            if (ctor === 'MouseEvent') {
                $.extend(opts, {button: 0, pointerX: 0, pointerY: 0, view: window});
            }
            if (options) {
                $.extend(opts, options);
            }
            if (typeof window[ctor] === 'function') {
                event = new window[ctor](type, opts);
                if (!element.dispatchEvent(event)) {
                    ret = false;
                }
            }
            else if (document.createEvent) {
                event = document.createEvent(ctor);
                event.initEvent(type, opts.bubbles, opts.cancelable);
                if (!element.dispatchEvent(event)) {
                    ret = false;
                }
            }
            else if (typeof element.fireEvent === 'function') {
                event = $.extend(document.createEventObject(), opts);
                if (!element.fireEvent('on' + type, event)) {
                    ret = false;
                }
            }
            else if (typeof element[type]) {
                element[type]();
            }
        }
        return ret;
    };

    /**
     * Strips HTML and returns just text.
     *
     * @param {String|Element|jQuery} html
     *   A string of HTML content, an Element DOM object or a jQuery object.
     *
     * @return {String}
     *   The text without HTML tags.
     *
     * @todo Replace with http://locutus.io/php/strings/strip_tags/
     */
    Bootstrap.stripHtml = function (html) {
        if (html instanceof $) {
            html = html.html();
        }
        else if (html instanceof Element) {
            html = html.innerHTML;
        }
        var tmp = document.createElement('DIV');
        tmp.innerHTML = html;
        return (tmp.textContent || tmp.innerText || '').replace(/^[\s\n\t]*|[\s\n\t]*$/, '');
    };

    /**
     * Provide a helper method for displaying when something is unsupported.
     *
     * @param {String} type
     *   The type of unsupported object, e.g. method or option.
     * @param {String} name
     *   The name of the unsupported object.
     * @param {*} [value]
     *   The value of the unsupported object.
     */
    Bootstrap.unsupported = function (type, name, value) {
        Bootstrap.warn('Unsupported by Drupal Bootstrap: (@type) @name -> @value', {
            '@type': type,
            '@name': name,
            '@value': typeof value === 'object' ? JSON.stringify(value) : value
        });
    };

    /**
     * Provide a helper method to display a warning.
     *
     * @param {String} message
     *   The message to display.
     * @param {Object} [args]
     *   Arguments to use as replacements in Drupal.formatString.
     */
    Bootstrap.warn = function (message, args) {
        if (this.settings.dev && console.warn) {
            console.warn(Drupal.formatString(message, args));
        }
    };

    /**
     * Wraps a plugin with common functionality.
     *
     * @param {Function} constructor
     *   A plugin constructor being wrapped.
     * @param {Object|Function} plugin
     *   The plugin being wrapped.
     * @param {Boolean} [extend = false]
     *   Whether to add super extensibility.
     */
    Bootstrap.wrapPluginConstructor = function (constructor, plugin, extend) {
        var proto = constructor.prototype;

        // Add a jQuery UI like option getter/setter method.
        var option = this.option;
        if (proto.option === void(0)) {
            proto.option = function () {
                return option.apply(this, arguments);
            };
        }

        if (extend) {
            // Handle prototype properties separately.
            if (plugin.prototype !== void 0) {
                for (var key in plugin.prototype) {
                    if (!plugin.prototype.hasOwnProperty(key)) continue;
                    var value = plugin.prototype[key];
                    if (typeof value === 'function') {
                        proto[key] = this.superWrapper(proto[key] || function () {}, value);
                    }
                    else {
                        proto[key] = $.isPlainObject(value) ? $.extend(true, {}, proto[key], value) : value;
                    }
                }
            }
            delete plugin.prototype;

            // Handle static properties.
            for (key in plugin) {
                if (!plugin.hasOwnProperty(key)) continue;
                value = plugin[key];
                if (typeof value === 'function') {
                    constructor[key] = this.superWrapper(constructor[key] || function () {}, value);
                }
                else {
                    constructor[key] = $.isPlainObject(value) ? $.extend(true, {}, constructor[key], value) : value;
                }
            }
        }
    };

    // Add Bootstrap to the global Drupal object.
    Drupal.bootstrap = Drupal.bootstrap || Bootstrap;

})(window._, window.jQuery, window.Drupal, window.drupalSettings);
;
(function ($, _) {

    /**
     * @class Attributes
     *
     * Modifies attributes.
     *
     * @param {Object|Attributes} attributes
     *   An object to initialize attributes with.
     */
    var Attributes = function (attributes) {
        this.data = {};
        this.data['class'] = [];
        this.merge(attributes);
    };

    /**
     * Renders the attributes object as a string to inject into an HTML element.
     *
     * @return {String}
     *   A rendered string suitable for inclusion in HTML markup.
     */
    Attributes.prototype.toString = function () {
        var output = '';
        var name, value;
        var checkPlain = function (str) {
            return str && str.toString().replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;') || '';
        };
        var data = this.getData();
        for (name in data) {
            if (!data.hasOwnProperty(name)) continue;
            value = data[name];
            if (_.isFunction(value)) value = value();
            if (_.isObject(value)) value = _.values(value);
            if (_.isArray(value)) value = value.join(' ');
            output += ' ' + checkPlain(name) + '="' + checkPlain(value) + '"';
        }
        return output;
    };

    /**
     * Renders the Attributes object as a plain object.
     *
     * @return {Object}
     *   A plain object suitable for inclusion in DOM elements.
     */
    Attributes.prototype.toPlainObject = function () {
        var object = {};
        var name, value;
        var data = this.getData();
        for (name in data) {
            if (!data.hasOwnProperty(name)) continue;
            value = data[name];
            if (_.isFunction(value)) value = value();
            if (_.isObject(value)) value = _.values(value);
            if (_.isArray(value)) value = value.join(' ');
            object[name] = value;
        }
        return object;
    };

    /**
     * Add class(es) to the array.
     *
     * @param {string|Array} value
     *   An individual class or an array of classes to add.
     *
     * @return {Attributes}
     *
     * @chainable
     */
    Attributes.prototype.addClass = function (value) {
        var args = Array.prototype.slice.call(arguments);
        this.data['class'] = this.sanitizeClasses(this.data['class'].concat(args));
        return this;
    };

    /**
     * Returns whether the requested attribute exists.
     *
     * @param {string} name
     *   An attribute name to check.
     *
     * @return {boolean}
     *   TRUE or FALSE
     */
    Attributes.prototype.exists = function (name) {
        return this.data[name] !== void(0) && this.data[name] !== null;
    };

    /**
     * Retrieve a specific attribute from the array.
     *
     * @param {string} name
     *   The specific attribute to retrieve.
     * @param {*} defaultValue
     *   (optional) The default value to set if the attribute does not exist.
     *
     * @return {*}
     *   A specific attribute value, passed by reference.
     */
    Attributes.prototype.get = function (name, defaultValue) {
        if (!this.exists(name)) this.data[name] = defaultValue;
        return this.data[name];
    };

    /**
     * Retrieves a cloned copy of the internal attributes data object.
     *
     * @return {Object}
     */
    Attributes.prototype.getData = function () {
        return _.extend({}, this.data);
    };

    /**
     * Retrieves classes from the array.
     *
     * @return {Array}
     *   The classes array.
     */
    Attributes.prototype.getClasses = function () {
        return this.get('class', []);
    };

    /**
     * Indicates whether a class is present in the array.
     *
     * @param {string|Array} className
     *   The class(es) to search for.
     *
     * @return {boolean}
     *   TRUE or FALSE
     */
    Attributes.prototype.hasClass = function (className) {
        className = this.sanitizeClasses(Array.prototype.slice.call(arguments));
        var classes = this.getClasses();
        for (var i = 0, l = className.length; i < l; i++) {
            // If one of the classes fails, immediately return false.
            if (_.indexOf(classes, className[i]) === -1) {
                return false;
            }
        }
        return true;
    };

    /**
     * Merges multiple values into the array.
     *
     * @param {Attributes|Node|jQuery|Object} object
     *   An Attributes object with existing data, a Node DOM element, a jQuery
     *   instance or a plain object where the key is the attribute name and the
     *   value is the attribute value.
     * @param {boolean} [recursive]
     *   Flag determining whether or not to recursively merge key/value pairs.
     *
     * @return {Attributes}
     *
     * @chainable
     */
    Attributes.prototype.merge = function (object, recursive) {
        // Immediately return if there is nothing to merge.
        if (!object) {
            return this;
        }

        // Get attributes from a jQuery element.
        if (object instanceof $) {
            object = object[0];
        }

        // Get attributes from a DOM element.
        if (object instanceof Node) {
            object = Array.prototype.slice.call(object.attributes).reduce(function (attributes, attribute) {
                attributes[attribute.name] = attribute.value;
                return attributes;
            }, {});
        }
        // Get attributes from an Attributes instance.
        else if (object instanceof Attributes) {
            object = object.getData();
        }
        // Otherwise, clone the object.
        else {
            object = _.extend({}, object);
        }

        // By this point, there should be a valid plain object.
        if (!$.isPlainObject(object)) {
            setTimeout(function () {
                throw new Error('Passed object is not supported: ' + object);
            });
            return this;
        }

        // Handle classes separately.
        if (object && object['class'] !== void 0) {
            this.addClass(object['class']);
            delete object['class'];
        }

        if (recursive === void 0 || recursive) {
            this.data = $.extend(true, {}, this.data, object);
        }
        else {
            this.data = $.extend({}, this.data, object);
        }

        return this;
    };

    /**
     * Removes an attribute from the array.
     *
     * @param {string} name
     *   The name of the attribute to remove.
     *
     * @return {Attributes}
     *
     * @chainable
     */
    Attributes.prototype.remove = function (name) {
        if (this.exists(name)) delete this.data[name];
        return this;
    };

    /**
     * Removes a class from the attributes array.
     *
     * @param {...string|Array} className
     *   An individual class or an array of classes to remove.
     *
     * @return {Attributes}
     *
     * @chainable
     */
    Attributes.prototype.removeClass = function (className) {
        var remove = this.sanitizeClasses(Array.prototype.slice.apply(arguments));
        this.data['class'] = _.without(this.getClasses(), remove);
        return this;
    };

    /**
     * Replaces a class in the attributes array.
     *
     * @param {string} oldValue
     *   The old class to remove.
     * @param {string} newValue
     *   The new class. It will not be added if the old class does not exist.
     *
     * @return {Attributes}
     *
     * @chainable
     */
    Attributes.prototype.replaceClass = function (oldValue, newValue) {
        var classes = this.getClasses();
        var i = _.indexOf(this.sanitizeClasses(oldValue), classes);
        if (i >= 0) {
            classes[i] = newValue;
            this.set('class', classes);
        }
        return this;
    };

    /**
     * Ensures classes are flattened into a single is an array and sanitized.
     *
     * @param {...String|Array} classes
     *   The class or classes to sanitize.
     *
     * @return {Array}
     *   A sanitized array of classes.
     */
    Attributes.prototype.sanitizeClasses = function (classes) {
        return _.chain(Array.prototype.slice.call(arguments))
            // Flatten in case there's a mix of strings and arrays.
            .flatten()

            // Split classes that may have been added with a space as a separator.
            .map(function (string) {
                return string.split(' ');
            })

            // Flatten again since it was just split into arrays.
            .flatten()

            // Filter out empty items.
            .filter()

            // Clean the class to ensure it's a valid class name.
            .map(function (value) {
                return Attributes.cleanClass(value);
            })

            // Ensure classes are unique.
            .uniq()

            // Retrieve the final value.
            .value();
    };

    /**
     * Sets an attribute on the array.
     *
     * @param {string} name
     *   The name of the attribute to set.
     * @param {*} value
     *   The value of the attribute to set.
     *
     * @return {Attributes}
     *
     * @chainable
     */
    Attributes.prototype.set = function (name, value) {
        var obj = $.isPlainObject(name) ? name : {};
        if (typeof name === 'string') {
            obj[name] = value;
        }
        return this.merge(obj);
    };

    /**
     * Prepares a string for use as a CSS identifier (element, class, or ID name).
     *
     * Note: this is essentially a direct copy from
     * \Drupal\Component\Utility\Html::cleanCssIdentifier
     *
     * @param {string} identifier
     *   The identifier to clean.
     * @param {Object} [filter]
     *   An object of string replacements to use on the identifier.
     *
     * @return {string}
     *   The cleaned identifier.
     */
    Attributes.cleanClass = function (identifier, filter) {
        filter = filter || {
            ' ': '-',
            '_': '-',
            '/': '-',
            '[': '-',
            ']': ''
        };

        identifier = identifier.toLowerCase();

        if (filter['__'] === void 0) {
            identifier = identifier.replace('__', '#DOUBLE_UNDERSCORE#');
        }

        identifier = identifier.replace(Object.keys(filter), Object.keys(filter).map(function(key) { return filter[key]; }));

        if (filter['__'] === void 0) {
            identifier = identifier.replace('#DOUBLE_UNDERSCORE#', '__');
        }

        identifier = identifier.replace(/[^\u002D\u0030-\u0039\u0041-\u005A\u005F\u0061-\u007A\u00A1-\uFFFF]/g, '');
        identifier = identifier.replace(['/^[0-9]/', '/^(-[0-9])|^(--)/'], ['_', '__']);

        return identifier;
    };

    /**
     * Creates an Attributes instance.
     *
     * @param {object|Attributes} [attributes]
     *   An object to initialize attributes with.
     *
     * @return {Attributes}
     *   An Attributes instance.
     *
     * @constructor
     */
    Attributes.create = function (attributes) {
        return new Attributes(attributes);
    };

    window.Attributes = Attributes;

})(window.jQuery, window._);
;
/**
 * @file
 * Theme hooks for the Drupal Bootstrap base theme.
 */
(function ($, Drupal, Bootstrap, Attributes) {

    /**
     * Fallback for theming an icon if the Icon API module is not installed.
     */
    if (!Drupal.icon) Drupal.icon = { bundles: {} };
    if (!Drupal.theme.icon || Drupal.theme.prototype.icon) {
        $.extend(Drupal.theme, /** @lends Drupal.theme */ {
            /**
             * Renders an icon.
             *
             * @param {string} bundle
             *   The bundle which the icon belongs to.
             * @param {string} icon
             *   The name of the icon to render.
             * @param {object|Attributes} [attributes]
             *   An object of attributes to also apply to the icon.
             *
             * @returns {string}
             */
            icon: function (bundle, icon, attributes) {
                if (!Drupal.icon.bundles[bundle]) return '';
                attributes = Attributes.create(attributes).addClass('icon').set('aria-hidden', 'true');
                icon = Drupal.icon.bundles[bundle](icon, attributes);
                return '<span' + attributes + '></span>';
            }
        });
    }

    /**
     * Callback for modifying an icon in the "bootstrap" icon bundle.
     *
     * @param {string} icon
     *   The icon being rendered.
     * @param {Attributes} attributes
     *   Attributes object for the icon.
     */
    Drupal.icon.bundles.bootstrap = function (icon, attributes) {
        attributes.addClass(['glyphicon', 'glyphicon-' + icon]);
    };

    /**
     * Add necessary theming hooks.
     */
    $.extend(Drupal.theme, /** @lends Drupal.theme */ {

        /**
         * Renders a Bootstrap AJAX glyphicon throbber.
         *
         * @returns {string}
         */
        ajaxThrobber: function () {
            return Drupal.theme('bootstrapIcon', 'refresh', {'class': ['ajax-throbber', 'glyphicon-spin'] });
        },

        /**
         * Renders a button element.
         *
         * @param {object|Attributes} attributes
         *   An object of attributes to apply to the button. If it contains one of:
         *   - value: The label of the button.
         *   - context: The context type of Bootstrap button, can be one of:
         *     - default
         *     - primary
         *     - success
         *     - info
         *     - warning
         *     - danger
         *     - link
         *
         * @returns {string}
         */
        button: function (attributes) {
            attributes = Attributes.create(attributes).addClass('btn');
            var context = attributes.get('context', 'default');
            var label = attributes.get('value', '');
            attributes.remove('context').remove('value');
            if (!attributes.hasClass(['btn-default', 'btn-primary', 'btn-success', 'btn-info', 'btn-warning', 'btn-danger', 'btn-link'])) {
                attributes.addClass('btn-' + Bootstrap.checkPlain(context));
            }

            // Attempt to, intelligently, provide a default button "type".
            if (!attributes.exists('type')) {
                attributes.set('type', attributes.hasClass('form-submit') ? 'submit' : 'button');
            }

            return '<button' + attributes + '>' + label + '</button>';
        },

        /**
         * Alias for "button" theme hook.
         *
         * @param {object|Attributes} attributes
         *   An object of attributes to apply to the button.
         *
         * @see Drupal.theme.button()
         *
         * @returns {string}
         */
        btn: function (attributes) {
            return Drupal.theme('button', attributes);
        },

        /**
         * Renders a button block element.
         *
         * @param {object|Attributes} attributes
         *   An object of attributes to apply to the button.
         *
         * @see Drupal.theme.button()
         *
         * @returns {string}
         */
        'btn-block': function (attributes) {
            return Drupal.theme('button', Attributes.create(attributes).addClass('btn-block'));
        },

        /**
         * Renders a large button element.
         *
         * @param {object|Attributes} attributes
         *   An object of attributes to apply to the button.
         *
         * @see Drupal.theme.button()
         *
         * @returns {string}
         */
        'btn-lg': function (attributes) {
            return Drupal.theme('button', Attributes.create(attributes).addClass('btn-lg'));
        },

        /**
         * Renders a small button element.
         *
         * @param {object|Attributes} attributes
         *   An object of attributes to apply to the button.
         *
         * @see Drupal.theme.button()
         *
         * @returns {string}
         */
        'btn-sm': function (attributes) {
            return Drupal.theme('button', Attributes.create(attributes).addClass('btn-sm'));
        },

        /**
         * Renders an extra small button element.
         *
         * @param {object|Attributes} attributes
         *   An object of attributes to apply to the button.
         *
         * @see Drupal.theme.button()
         *
         * @returns {string}
         */
        'btn-xs': function (attributes) {
            return Drupal.theme('button', Attributes.create(attributes).addClass('btn-xs'));
        },

        /**
         * Renders a glyphicon.
         *
         * @param {string} name
         *   The name of the glyphicon.
         * @param {object|Attributes} [attributes]
         *   An object of attributes to apply to the icon.
         *
         * @returns {string}
         */
        bootstrapIcon: function (name, attributes) {
            return Drupal.theme('icon', 'bootstrap', name, attributes);
        }

    });

})(window.jQuery, window.Drupal, window.Drupal.bootstrap, window.Attributes);
;
(function ($, Drupal) {
    Drupal.behaviors.myModuleBehavior = {
        attach: function (context, settings) {
            let PubSub = Drupal.behaviors.PubSub;
            let AirNowGov = Drupal.behaviors.AirNowGov;
            let ReportingArea = AirNowGov.ReportingArea;
            let GeoLocation = AirNowGov.GeoLocation;
            let Tooltips = AirNowGov.Tooltips;

            let themeDirectory = settings.themeDirectory;
            let themeImgDirectory = themeDirectory + /images/;

            const MAX_ROTATION_DEGREES = 180;
            const MIN_ROTATION_DEGREES = 0;

            $(document).ready(function(){
                smoothScrollingAnchors();

                bindNavToolEvents();
                GeoLocation.enableGeolocationLookupField("location-input-style");

                $(".navbar .location-input-gps-btn").on("click", function() {
                    // TODO: disable if blocked by user
                    GeoLocation.requestUserLocation();
                });

                // Events to accomodate small screen sizes and the lack of status bar real estate.

                // Expand geo-search input, and hide alerts & announcements
                $("#nav-geosearch-tool .location-input").click(function() {
                    let $this = $(this);
                    if (!$this.hasClass("aqi-nav-scroll-hidden")) {
                        $(".nav-left-side-toolbar").parent().toggleClass("mobile-inactive", true);
                        setTimeout(function() {
                            $this.toggleClass("active", true);
                        }, 175);
                    }
                });

                // Shrink geo-search input, and show alerts & announcements
                $(document).click(function(event) {
                    $target = $(event.target);
                    if(!$target.closest("#nav-geosearch-tool .location-input").length && $("#nav-geosearch-tool .location-input").is(":visible")) {
                        $("#nav-geosearch-tool .location-input").removeClass('active');
                        setTimeout(function() {
                            $(".nav-left-side-toolbar").parent().toggleClass("mobile-inactive", false);
                        }, 175);
                    }
                });

                PubSub.subscribe(ReportingArea.TOPICS.new_data, function() {
                    populateData();
                    populateDialData();
                    /* AirnowDrupal # 122 Nav Bar redirects to Dial page from Content pages cw 2019-05-17 */
                    //if (String(window.location).indexOf("?") < 0) {
                    // $(location).attr('href','/');
                    //};
                });
                populateData();
                populateDialData();

                dismissStatus();
            });

            function dismissStatus() {
                // AirNowDrupal # 112 Multiple Changes cw 2019-04-10
                $(".status-message-container .status-message-dismiss").on("click.dismissStatus", function() {
                    $(".status-message-container").addClass("hidden");
                    // AirnowDrupal # 132 Dismissed alert creates a non-presistant cookie Save cw 2019-05-29
                    $(document).ready(function() {
                        cookieValue = escape("1") + ";";
                        document.cookie = "statusMessageDismiss=" + cookieValue;
                    });
                });

                $(".bb-mobile-status-bar .status-message-dismiss").on("click.dismissStatus", function() {
                    $(".bb-mobile-status-bar").removeClass("visible-xs").addClass("hidden");
                    // AirnowDrupal # 132 Dismissed alert creates a non-presistant cookie Save cw 2019-05-29
                    $(document).ready(function() {
                        cookieValue = escape("1") + ";";
                        document.cookie = "statusMessageDismiss=" + cookieValue;
                    });
                });
            }

            function getDegree(aqi) {
                let deg;
                // AQI values 0 - 200 represent the first 4/6 of the dial
                if (aqi <= 200) {
                    deg = (aqi / 200) * (MAX_ROTATION_DEGREES * (4/6));
                }
                // AQI values 201 - 300 represent the second to last 1/6 of the dial
                else if (aqi <= 300) {
                    deg = (MAX_ROTATION_DEGREES * (4/6)) + ((((aqi-200) / (300-200))) * (MAX_ROTATION_DEGREES * (1/6)))
                }
                // AQI values 301 - 500 represent the last 1/6 of the dial
                else if (aqi <= 500) {
                    deg = (MAX_ROTATION_DEGREES * (5/6)) + ((((aqi-300) / (500-300))) * (MAX_ROTATION_DEGREES * (1/6)))
                }
                // AQI values above 400 should just be treated as the maximum rotation
                else {
                    deg = MAX_ROTATION_DEGREES;
                }
                return deg;
            }

            function toggleNoDataDisplay(noData) {
                $(".mobile-city").toggleClass("noData", noData);
                $(".bb-info-holder").toggleClass("noData", noData);
                if (noData) {
                    $(".bb-info-holder .curr-cond-label a").html("Get Current and Forecast Air Quality for Your Area");
                } else {
                    $(".bb-info-holder .curr-cond-label a").html("Current Conditions");
                }
                $(".bb-info-holder .aqi-container").toggleClass("hidden", false);
                $(".bb-info-holder #nav-aqi-tool").toggleClass("hidden", false);
            }

            // Rotates the arrow to the provided degrees.  Degree values capped at 0 and 180
            function rotateArrow(deg) {
                // Ensure we do not rotate too far in either direction
                deg = Math.max(MIN_ROTATION_DEGREES, Math.min(deg, MAX_ROTATION_DEGREES));
                // Apply the rotation
                let arrows = document.getElementsByClassName("aq-dial-arrow");
                for (let i = 0; i < arrows.length; i++) {
                    let arrow = arrows[i];
                    arrow.style.webkitTransform = "rotate("+deg+"deg)";
                    arrow.style.mozTransform = "rotate("+deg+"deg)";
                    arrow.style.msTransform = "rotate("+deg+"deg)";
                    arrow.style.oTransform = "rotate("+deg+"deg)";
                    arrow.style.transform = "rotate("+deg+"deg)";
                }
            }

            $('.band-back-to-top').on("click.backToTop", function(){
                $("html, body").animate({ scrollTop: 0 }, 500);
                return false;
            });


            // Search Button Click Events
            $(document).once("closeSearchBtnEnableDoc").on("click.searchBtnClose", function(){
                handleSearchDropDown(false);
            });

            $('.dropdown.dropdown-search').find('.dropdown-content').on('click', function(event){
                event.stopPropagation();
            });

            addDropdownButtonListener();
            addAQIDropdownButtonListener();
            // addAQINavScroll();

            // Mobile dropdown click event
            $(".mobile-dropdown").on("click", function(event) {
                if($("#master-navbar").hasClass("mobile-nav")) {
                    $("#master-navbar").removeClass("mobile-nav");
                } else {
                    $("#master-navbar").addClass("mobile-nav");
                }
            });

            function populateData() {
                let currentAQData = ReportingArea.getMaxCurrentReportingAreaData();
                // let forecastAQDataToday = ReportingArea.getMaxForecastReportingAreaData(0);
                // let forecastAQDataTomorrow = ReportingArea.getMaxForecastReportingAreaData(1);
                let locationDisplayName = GeoLocation.getLocationDisplayName();

                let hasData = currentAQData || locationDisplayName;

                toggleNoDataDisplay(!hasData);

                if (hasData) {
                    let category = currentAQData[ReportingArea.FIELDS.category];
                    let aqiStatusClass = "default";
                    let allClasses = "default good moderate unhealthy-sensitive unhealthy very-unhealthy hazardous";

                    if (category === "Good") {
                        aqiStatusClass = "good"; // green, good
                    } else if (category === "Moderate") {
                        aqiStatusClass = "moderate"; // yellow, moderate
                    } else if (category === "Unhealthy for Sensitive Groups") {
                        aqiStatusClass = "unhealthy-sensitive"; // orange, semi unhealthy
                    } else if (category === "Unhealthy") {
                        aqiStatusClass = "unhealthy"; // red, unhealthy
                    } else if (category === "Very Unhealthy") {
                        aqiStatusClass = "very-unhealthy"; // purple, very unhealthy
                    } else if (category === "Hazardous") {
                        aqiStatusClass = "hazardous"; // maroon, hazardous
                    }

                    $(".curr-cond-label a").text(locationDisplayName);

                    $(".btn.btn-aqi-nav").removeClass(allClasses).addClass(aqiStatusClass);
                }
            }

            function populateDialData() {
                if($('.marquee').length > 0) {
                    return;
                }

                // $('.marquee').css(
                //   { 'background': 'url('+themeImgDirectory+'default_marquee_img.jpg)',
                //     'background-attachment': 'fixed',
                //     'background-position': 'center',
                //     'background-repeat': 'no-repeat',
                //     'background-size': 'cover'
                //   }
                // );

                let currentAQData = ReportingArea.getMaxCurrentReportingAreaData();
                let forecastAQDataToday = ReportingArea.getMaxForecastReportingAreaData(0);
                let forecastAQDataTomorrow = ReportingArea.getMaxForecastReportingAreaData(1);
                let locationDisplayName = GeoLocation.getLocationDisplayName();

                if (currentAQData) {
                    let categoryImageType = "not_available";
                    let aqi = currentAQData[ReportingArea.FIELDS.aqi];
                    let category = currentAQData[ReportingArea.FIELDS.category];
                    if (category === "Good") {
                        categoryImageType = "good"; // good
                    } else if (category === "Moderate") {
                        categoryImageType = "moderate"; // moderate
                    } else if (category === "Unhealthy for Sensitive Groups") {
                        categoryImageType = "usg"; // semi unhealthy
                    } else if (category === "Unhealthy") {
                        categoryImageType = "unhealthy"; // unhealthy
                    } else if (category === "Very Unhealthy") {
                        categoryImageType = "very_unhealthy"; // very unhealthy
                    } else if (category === "Hazardous") {
                        if (aqi < 501) {
                            categoryImageType = "hazardous"; // hazardous
                        } else {
                            categoryImageType = "beyond_index"; // beyond aqi
                            category = "Beyond the AQI"; // Must be set for the pop-up rollover. Not in JSON data cw 2019-10-07
                        }
                    }

                    $(".aq-dial .aq-dial-status").attr("src", "/themes/anblue/images/dial2/dial_" + categoryImageType + ".svg");

                    // FIXME: Needs integration into new dial
                    // Tooltips.createTip(".marquee-dial-col-holder .marquee-dial-status-tooltip-hotspot", "categories", "right", category, currentAQData[ReportingArea.FIELDS.parameter], null, 0);
                    // Tooltips.createTip(".marquee-dial-col-holder #pp-data", "pollutant", "top", null, currentAQData[ReportingArea.FIELDS.parameter]);

                    // Note that setTimeout needed to allow initial animation to play
                    setTimeout(function () {
                        let deg = getDegree(aqi);
                        rotateArrow(deg);
                    }, 0);

                    // Convert reporting area's 24-hour update time to 12-hour
                    let time;
                    let rawTime = currentAQData[ReportingArea.FIELDS.time];
                    let hour = rawTime.split(":")[0];
                    let minute = rawTime.split(":")[1];
                    if (Number(hour) < 12) { // 12:00 AM - 11:59 AM
                        if (Number(hour) === 0) {
                            time = "12:" + minute + " AM";
                        } else {
                            time = "" + Number(hour) + ":" + minute + " AM";
                        }
                    } else { // 12:00 PM - 11:59 PM
                        if (Number(hour) === 12) {
                            time = rawTime + " PM";
                        } else {
                            time = "" + Number(hour - 12) + ":" + minute + " PM";
                        }
                    }
                    let tz = currentAQData[ReportingArea.FIELDS.timezone];
                    $(".aq-dial .aq-updated-time").html(time + " " + tz);

                    $(".aq-dial .aq-dial-arrow").show();

                    $(".aq-dial .aqi").text("NowCast AQI " + aqi);
                    $(".aq-dial .pollutant").text(currentAQData[ReportingArea.FIELDS.parameter]);
                    // FIXME: Currently not supported in new dial
                    // if (currentAQData[ReportingArea.FIELDS.parameter] === "PM2.5"
                    //   || currentAQData[ReportingArea.FIELDS.parameter] === "PM10") {
                    //   $(".pp-label-text p").text("Particle Pollution");
                    // } else {
                    //   $(".pp-label-text p").text("");
                    // }

                    $(".location-label").text(locationDisplayName);
                    $(".mobile-location-label").text(locationDisplayName);
                    $(".splash-sub-message").text("");
                    // AirNowDrupal # 118 Remove More Cities button cw 2019-04-01
                    //$(".state-air-quality").text("More Cities in " + handleLongStateName(locationStateName));
                    //$(".state-air-quality").off("click").on("click", function() {
                    //  let win = window.open("/state/" + locationStateName.replace(/ /g, "-").toLowerCase(), "_self");
                    //  win.focus();
                    //});
                } else {
                    $(".aq-dial .aq-updated-time").text("").hide();
                    $(".aq-dial .aq-dial-arrow").hide();
                    $(".aq-dial .aqi").text("NowCast AQI N/A");
                    $(".aq-dial .pollutant").text("N/A");
                    $(".aq-dial .aq-dial-status").attr("src", "/themes/anblue/images/dial2/dial_not_available.svg");

                    $(".location-label").text(locationDisplayName);
                    $(".mobile-location-label").text(locationDisplayName);
                    // AirNowDrupal # 118 Remove More Cities button cw 2019-04-01
                    //$(".state-air-quality").text("More Cities in " + handleLongStateName(locationStateName));
                    //$(".state-air-quality").off("click").on("click", function() {
                    //  let win = window.open("/state/" + locationStateName.replace(/ /g, "-").toLowerCase(), "_self");
                    //  win.focus();
                    //});

                }

                // FIXME: Delete this code block once corner forecast widget is removed
                $(".aq-forecast-label").text("Air Quality Forecast");
                let hasActionDay = false;
                let todayHasActionDay = false;
                let tomorrowHasActionDay = false;
                if (forecastAQDataToday) {
                    hasActionDay = hasActionDay || forecastAQDataToday[ReportingArea.FIELDS.isActionDay];
                    todayHasActionDay = false || forecastAQDataToday[ReportingArea.FIELDS.isActionDay];
                }
                if (forecastAQDataTomorrow) {
                    hasActionDay = hasActionDay || forecastAQDataTomorrow[ReportingArea.FIELDS.isActionDay];
                    tomorrowHasActionDay = false || forecastAQDataTomorrow[ReportingArea.FIELDS.isActionDay];
                }
                $(".aq-dial .forecast-aq-container .today-aq-data .action-day").toggle(todayHasActionDay);
                $(".aq-dial .forecast-aq-container .tomorrow-aq-data .action-day").toggle(tomorrowHasActionDay);


                if (forecastAQDataToday) {
                    let category = forecastAQDataToday[ReportingArea.FIELDS.category];
                    let fcstCategory = "no-data";
                    let smallFont = false;
                    if (category === "Good") {
                        fcstCategory = "good"; // good
                    } else if (category === "Moderate") {
                        fcstCategory = "moderate"; // moderate
                    } else if (category === "Unhealthy for Sensitive Groups") {
                        fcstCategory = "unhealthy-sensitive"; // semi unhealthy
                        smallFont = true;
                    } else if (category === "Unhealthy") {
                        fcstCategory = "unhealthy"; // unhealthy
                    } else if (category === "Very Unhealthy") {
                        fcstCategory = "very-unhealthy"; // very unhealthy
                    } else if (category === "Hazardous") {
                        fcstCategory = "hazardous"; // hazardous
                    }
                    let circle = $(".aq-dial .forecast-aq-container .today-aq-data .circle");
                    $(circle)
                        .toggleClass("good", category === "Good")
                        .toggleClass("moderate", category === "Moderate")
                        .toggleClass("unhealthy-sensitive", category === "Unhealthy for Sensitive Groups")
                        .toggleClass("unhealthy", category === "Unhealthy")
                        .toggleClass("very-unhealthy", category === "Very Unhealthy")
                        .toggleClass("hazardous", category === "Hazardous")
                        .toggleClass("no-data-fcst", false);
                    let categoryText = $(".aq-dial .forecast-aq-container .today-aq-data .category");
                    $(categoryText).text(category, true);
                    $(categoryText).toggleClass("smallfont", smallFont);
                } else {
                    let circle = $(".aq-dial .forecast-aq-container .today-aq-data .circle");
                    $(circle).toggleClass("no-data-fcst", true);
                    let categoryText = $(".aq-dial .forecast-aq-container .today-aq-data .category");
                    $(categoryText).text("Not Available", true);
                }
                if (forecastAQDataTomorrow) {
                    let category = forecastAQDataTomorrow[ReportingArea.FIELDS.category];
                    let fcstCategory = "no-data";
                    let smallFont = false;
                    if (category === "Good") {
                        fcstCategory = "good"; // good
                    } else if (category === "Moderate") {
                        fcstCategory = "moderate"; // moderate
                    } else if (category === "Unhealthy for Sensitive Groups") {
                        fcstCategory = "unhealthy-sensitive "; // semi unhealthy
                        smallFont = true;
                    } else if (category === "Unhealthy") {
                        fcstCategory = "unhealthy"; // unhealthy
                    } else if (category === "Very Unhealthy") {
                        fcstCategory = "very-unhealthy"; // very unhealthy
                    } else if (category === "Hazardous") {
                        fcstCategory = "hazardous"; // hazardous
                    }
                    let circle = $(".aq-dial .forecast-aq-container .tomorrow-aq-data .circle");
                    $(circle)
                        .toggleClass("good", category === "Good")
                        .toggleClass("moderate", category === "Moderate")
                        .toggleClass("unhealthy-sensitive", category === "Unhealthy for Sensitive Groups")
                        .toggleClass("unhealthy", category === "Unhealthy")
                        .toggleClass("very-unhealthy", category === "Very Unhealthy")
                        .toggleClass("hazardous", category === "Hazardous")
                        .toggleClass("no-data-fcst", false);
                    let categoryText = $(".aq-dial .forecast-aq-container .tomorrow-aq-data .category");
                    $(categoryText).text(category, true);
                    $(categoryText).toggleClass("smallfont", smallFont);
                } else {
                    let circle = $(".aq-dial .forecast-aq-container .tomorrow-aq-data .circle");
                    $(circle).toggleClass("no-data-fcst", true);
                    let categoryText = $(".aq-dial .forecast-aq-container .tomorrow-aq-data .category");
                    $(categoryText).text("Not Available", true);
                }
                $(".current-aq-label h4").text("Current Air Quality");
                $(".aq-forecast-label").text("Air Quality Forecast");

                // setMarqueeForecastSections(forecastAQDataToday, ReportingArea, ".aq-day-current", "Today");
                // setMarqueeForecastSections(forecastAQDataTomorrow, ReportingArea, ".aq-day-next", "Tomorrow");
            }
        }
    };

    // function addAQINavScroll() {
    //   if($("#location-input").length > 0) {
    //     $(".aqi-nav-scroll").addClass("aqi-nav-scroll-hidden");
    //     $(document).on("scroll", function() {
    //         if($("#location-input").offset().top >= $("#bb-nav").offset().top) {
    //           $(".aqi-nav-scroll").addClass("aqi-nav-scroll-hidden");
    //           removeAQIDropdownButtonListener();
    //         } else {
    //           $(".aqi-nav-scroll").removeClass("aqi-nav-scroll-hidden");
    //           addAQIDropdownButtonListener();
    //         }
    //     });
    //   }
    // }

    function addAQIDropdownButtonListener() {
        $(".btn.btn-aqi-nav").once("aqiNavBtnEnable").on("click.aqiBtnOpen", function(event) {
            event.stopPropagation();
            handleAQIDropdownButton();
        });
    }
    //
    // function removeAQIDropdownButtonListener() {
    //   $(".btn.btn-aqi-nav").removeOnce("aqiNavBtnEnable").off("click.aqiBtnOpen");
    // }

    function handleAQIDropdownButton() {
        $(".aq-dial.status-bar").toggle();
        $(".btn-aqi-nav .aqi-nav-text").toggle();
        $(".btn-aqi-nav .fa.fa-times").toggle();
    }

    function addDropdownButtonListener() {
        $("#search-btn").once("searchBtnEnable").on("click.searchBtnOpen", function(event) {
            event.stopPropagation();
            handleSearchDropDown(true);
        });
    }

    function handleSearchDropDown(enabled) {
        let searchBtn = $("#search-btn");
        let dropdownSearch = $('.dropdown.dropdown-search').find('.dropdown-content');
        if(enabled) {
            dropdownSearch.css("display", "block");
            searchBtn.find(".fa-search").toggle(false);
            searchBtn.find(".fa-times").toggle(true);
            searchBtn.removeOnce("searchBtnEnable").off("click.searchBtnOpen");

            searchBtn.once("closeSearchBtnEnable").on("click.searchBtnClose", function(event){
                event.stopPropagation();
                handleSearchDropDown(false);
            });
        } else {
            dropdownSearch.css("display", "none");
            searchBtn.find(".fa-search").toggle(true);
            searchBtn.find(".fa-times").toggle(false);
            addDropdownButtonListener();
            searchBtn.removeOnce("closeSearchBtnEnable").off("click.searchBtnClose");
        }
    }

    // Set jQuery events for the navigation tools
    function bindNavToolEvents() {
        let navTools = $(".nav-left-side-toolbar .nav-tool");
        let navToolPopups = $(".nav-left-side-toolbar .nav-tool-popup");
        let navToolPopupArrows = navTools.find(".nav-tool-popup-arrow");
        let navToolPopupDismisses = navToolPopups.find(".popup-dismiss");

        // Toggle Tool Popups
        navTools.click(function() {
            let $this = $(this);
            // If we are on narrow screens, move to new
            if ($(document).width() <= 510) {
                window.location = $this.next().find(".view-all-link a").attr('href');
            }
            let thisNavToolPopup = $this.next();
            let thisNavToolPopupArrow = $this.find(".nav-tool-popup-arrow");
            navTools.not($this).removeClass('active');
            $this.toggleClass('active');
            navToolPopups.not(thisNavToolPopup).hide();
            navToolPopupArrows.not(thisNavToolPopupArrow).hide();
            thisNavToolPopupArrow.toggle();
            thisNavToolPopup.toggle();
        });

        // Dismiss Tool Popup
        navToolPopupDismisses.click(function() {
            let $this = $(this);
            let thisNavToolPopup = $this.parent();
            let thisNavTool = thisNavToolPopup.prev();
            let thisNavToolPopupArrow = thisNavTool.find(".nav-tool-popup-arrow");
            thisNavToolPopup.hide();
            thisNavToolPopupArrow.hide();
            thisNavTool.removeClass('active');
        });

        // Close Tool Popup
        $(document).click(function(event) {
            $target = $(event.target);
            if(!$target.closest(navTools).length && !$target.closest(navToolPopups).length && navTools.is(":visible")) {
                navToolPopups.hide();
                navToolPopupArrows.hide();
                navTools.removeClass('active');
            }
        });
    }

    // This has code regarding anchor clicks. When clicks are done, they will smoothly scroll to the anchor and
    // account for the height offset of the navigation bar
    function smoothScrollingAnchors() {

        let $htmlbody = $('html, body');
        let smoothScroll = function(event) {
            let hash;
            if(event) {
                event.preventDefault();
                hash = $.attr(this, 'href');
            } else {
                hash = location.hash;
            }

            let navOffset = $("#master-navbar").height() - 1;
            $htmlbody.animate({
                scrollTop: ($(hash).offset().top - navOffset)
            }, 500);
        };

        $(document).on('click.smoothAnchors', 'a[href^="#"]', smoothScroll);

        //  This is the smooth scroll to an anchor in the url (if that exists)
        // $('html, body').hide();
        if(location.hash) {
            setTimeout(function () {
                $('html, body').scrollTop(0).show();
                smoothScroll();
            }, 0);
        } else {
            // $('html, body').show();
        }
    }
})(jQuery, Drupal);
;
