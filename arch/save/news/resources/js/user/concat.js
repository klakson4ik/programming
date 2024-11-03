class jsLib {


    constructor(selector)
    {   

        if(typeof selector === "string"){
            this.collection = document.getElementsByClassName(selector)
            this.size = this.collection.length; 
        }else{
           this.node = selector; 
        }


    }


	html(htmlContent) {
        for (const el of this.collection) {
			el.innerHTML = htmlContent;
		}

		return this;
	}

	text(textContent) {
		if (textContent === undefined) {
			const el = Array.from(this.collection)[0];
			return el.textContent;
		}

		for (const el of this.collection) {
			el.textContent = textContent;
		}

		return this;
	}

	on(name, handler) {
//        if(this.is_one)
 //           this.collection.addEventListener(name, handler)
//        else{
//		    for (const element of this.collection) {
//			    element.addEventListener(name, handler);
//		    }
  //      }
        for(let i = 0; i < this.collection.length; ++i){
            this.collection[i].addEventListener(name, handler)
        }

		return this;
	}

    children(selector, unique = false){
        this.collection = this.node.getElementsByClassName(selector)
        return this;

    }

//	attr(name, value) {
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

	addClass(className) {
		for (const el of this.collection) {
			el.classList.add(className);
		}

		return this;
	}

//	each(callback) {
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

	css(propertyName, value) {
//		if (value === undefined) {
//			const el = Array.from(this.container)[0];
//			return el.style[propertyName];
//		} else {
//        if(this.is_one){
//			this.collection.style[propertyName] = value;
//       }else{
			for (const element of this.collection) {
				element.style[propertyName] = value;
			}
//        }
//
		return this;
	}

//	is(cssSelector) {
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
}
const $ = (selector) => new jsLib(selector);

$("up");

class Category
{
    constructor(root, element, text){
		  this.btnBurger = document.querySelector(".menu-burger");
        this.rootNode = document.querySelector(root);
        this.element = element;
        this.text = text;
        this.activation(this.rootNode);
        this.menuToggle();
    };
	
	 menuToggle(){
		this.btnBurger.addEventListener("click", (e) => {
      if(this.rootNode.style.display === "inline-block")
        this.rootNode.style.display = "none";
      else
        this.rootNode.style.display = "inline-block";
		});
	 }

    activation(node){
      let nodes = node.children;
      for(let i = 0; i < nodes.length; ++i){
          nodes[i].addEventListener("click", (e) => {
            e.stopPropagation();
            let children = e.currentTarget.querySelector(`.${this.element}`)
            if(children !== null){
              for(let j = 0; j < nodes.length; ++j){
                if(nodes[j] !== e.currentTarget){
                  this.recursiveCloseCategory(nodes[j])
                }else{
                  children.style.display = "block";
                }
              }
              this.activation(children)
            }
         })
      }
    }

  recursiveCloseCategory(node){
    let hideNode = node.querySelector(`.${this.element}`)
    if(hideNode !== null){
      let hideNodeChild = hideNode.getElementsByClassName(this.element)
      for(let i = 0; i < hideNodeChild.length; ++i){
        if(hideNodeChild[i].style.display === "block"){
          hideNodeChild[i].style.display = "none";
          hideNodeChild[i].querySelector(this.text).style.color = ""
        }
      }
      hideNode.style.display = "none"
      hideNode.querySelector(this.text).style.color = ""
      node.querySelector(this.text).style.color = ""
    }
  }
}
if(window.matchMedia('(max-width: 1024px)'))
  new Category(".category-tree", "category-tree-element", ".category-branch-text");


//if(document.location.pathname === "/Home")
//new Home;

//if(document.location.pathname === "/News")
//new News;
