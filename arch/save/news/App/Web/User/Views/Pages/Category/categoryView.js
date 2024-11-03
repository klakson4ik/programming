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

