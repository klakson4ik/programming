"use strict";

function _createForOfIteratorHelper(o, allowArrayLike) { var it; if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = o[Symbol.iterator](); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var jsLib = /*#__PURE__*/function () {
  function jsLib(selector) {
    _classCallCheck(this, jsLib);

    if (typeof selector === "string") {
      this.collection = document.getElementsByClassName(selector);
      this.size = this.collection.length;
    } else {
      this.node = selector;
    }
  }

  _createClass(jsLib, [{
    key: "html",
    value: function html(htmlContent) {
      var _iterator = _createForOfIteratorHelper(this.collection),
          _step;

      try {
        for (_iterator.s(); !(_step = _iterator.n()).done;) {
          var el = _step.value;
          el.innerHTML = htmlContent;
        }
      } catch (err) {
        _iterator.e(err);
      } finally {
        _iterator.f();
      }

      return this;
    }
  }, {
    key: "text",
    value: function text(textContent) {
      if (textContent === undefined) {
        var el = Array.from(this.collection)[0];
        return el.textContent;
      }

      var _iterator2 = _createForOfIteratorHelper(this.collection),
          _step2;

      try {
        for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
          var _el = _step2.value;
          _el.textContent = textContent;
        }
      } catch (err) {
        _iterator2.e(err);
      } finally {
        _iterator2.f();
      }

      return this;
    }
  }, {
    key: "on",
    value: function on(name, handler) {
      //        if(this.is_one)
      //           this.collection.addEventListener(name, handler)
      //        else{
      //		    for (const element of this.collection) {
      //			    element.addEventListener(name, handler);
      //		    }
      //      }
      for (var i = 0; i < this.collection.length; ++i) {
        this.collection[i].addEventListener(name, handler);
      }

      return this;
    }
  }, {
    key: "children",
    value: function children(selector) {
      var unique = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
      this.collection = this.node.getElementsByClassName(selector);
      return this;
    } //	attr(name, value) {
    //		if (value === undefined) {
    //			const el = Array.from(this.container)[0];
    //			return el.getAttribute(name);
    //		} else {
    //			for (const el of this.container) {
    //				el.setAttribute(name, value);
    //			}
    //		}
    //		return this;
    //	}
    //	click(handler) {
    //		if (handler === undefined) {
    //			for (const el of this.container) {
    //				el.click();
    //			}
    //		} else {
    //			for (const el of this.container) {
    //				el.addEventListener("click", handler);
    //			}
    //		}
    //		return this;
    //	}

  }, {
    key: "addClass",
    value: function addClass(className) {
      var _iterator3 = _createForOfIteratorHelper(this.collection),
          _step3;

      try {
        for (_iterator3.s(); !(_step3 = _iterator3.n()).done;) {
          var el = _step3.value;
          el.classList.add(className);
        }
      } catch (err) {
        _iterator3.e(err);
      } finally {
        _iterator3.f();
      }

      return this;
    } //	each(callback) {
    //		const container = Array.from(this.container);
    //
    //		for (let i = 0; i < container.length; i++) {
    //			const result = callback.call(container[i], i, container[i]);
    //
    //			if (result === false) {
    //				break;
    //			}
    //		}
    //		return this;
    //	}

  }, {
    key: "css",
    value: function css(propertyName, value) {
      //		if (value === undefined) {
      //			const el = Array.from(this.container)[0];
      //			return el.style[propertyName];
      //		} else {
      //        if(this.is_one){
      //			this.collection.style[propertyName] = value;
      //       }else{
      var _iterator4 = _createForOfIteratorHelper(this.collection),
          _step4;

      try {
        for (_iterator4.s(); !(_step4 = _iterator4.n()).done;) {
          var element = _step4.value;
          element.style[propertyName] = value;
        } //        }
        //

      } catch (err) {
        _iterator4.e(err);
      } finally {
        _iterator4.f();
      }

      return this;
    } //	is(cssSelector) {
    //		const elems = Array.from(document.querySelectorAll(cssSelector));
    //		const container = Array.from(this.container);
    //
    //		for (const el of container) {
    //			if (!elems.includes(el)) {
    //				return false;
    //			}
    //		}
    //
    //		return true;
    //	}
    //}

  }]);

  return jsLib;
}();

var $ = function $(selector) {
  return new jsLib(selector);
};

$("up");

var Category = /*#__PURE__*/function () {
  function Category(root, element, text) {
    _classCallCheck(this, Category);

    this.btnBurger = document.querySelector(".menu-burger");
    this.rootNode = document.querySelector(root);
    this.element = element;
    this.text = text;
    this.activation(this.rootNode);
    this.menuToggle();
  }

  _createClass(Category, [{
    key: "menuToggle",
    value: function menuToggle() {
      var _this = this;

      this.btnBurger.addEventListener("click", function (e) {
        if (_this.rootNode.style.display === "inline-block") _this.rootNode.style.display = "none";else _this.rootNode.style.display = "inline-block";
      });
    }
  }, {
    key: "activation",
    value: function activation(node) {
      var _this2 = this;

      var nodes = node.children;

      for (var i = 0; i < nodes.length; ++i) {
        nodes[i].addEventListener("click", function (e) {
          e.stopPropagation();
          var children = e.currentTarget.querySelector(".".concat(_this2.element));

          if (children !== null) {
            for (var j = 0; j < nodes.length; ++j) {
              if (nodes[j] !== e.currentTarget) {
                _this2.recursiveCloseCategory(nodes[j]);
              } else {
                children.style.display = "block";
              }
            }

            _this2.activation(children);
          }
        });
      }
    }
  }, {
    key: "recursiveCloseCategory",
    value: function recursiveCloseCategory(node) {
      var hideNode = node.querySelector(".".concat(this.element));

      if (hideNode !== null) {
        var hideNodeChild = hideNode.getElementsByClassName(this.element);

        for (var i = 0; i < hideNodeChild.length; ++i) {
          if (hideNodeChild[i].style.display === "block") {
            hideNodeChild[i].style.display = "none";
            hideNodeChild[i].querySelector(this.text).style.color = "";
          }
        }

        hideNode.style.display = "none";
        hideNode.querySelector(this.text).style.color = "";
        node.querySelector(this.text).style.color = "";
      }
    }
  }]);

  return Category;
}();

if (window.matchMedia('(max-width: 1024px)')) new Category(".category-tree", "category-tree-element", ".category-branch-text"); //if(document.location.pathname === "/Home")
//new Home;
//if(document.location.pathname === "/News")
//new News;