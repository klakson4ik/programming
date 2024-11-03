class Category
{
    constructor(root, element, text){
        this.rootNode = document.querySelector(root);
        this.element = element;
        this.text = text;
//        this.root = document.querySelector(".category-root"); 
        this.activation(this.rootNode);
    };

    activation(node){
      let nodes = node.children;
      for(let i = 0; i < nodes.length; ++i){
          nodes[i].addEventListener("click", (e) => {
            e.stopPropagation();
            let children = e.currentTarget.querySelector(`.${this.element}`)
            if(children !== null){
  //            this.addRoot(e.currentTarget);
              for(let j = 0; j < nodes.length; ++j){
                if(nodes[j] !== e.currentTarget){
                  this.recursiveCloseCategory(nodes[j])
                }else{
                  children.style.display = "block";
                  nodes[j].querySelector(this.text).style.color = "red"
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

  addRoot(target){
      let branchLastChild = this.root.querySelector(".category-root-element:last-child");
      let text = target.querySelector(".category-branch-text").textContent;
      let element= "<li class='category-root-element'>" + text + "</li>"
      branchLastChild.insertAdjacentHTML("afterEnd", element);
  }

}

if(document.location.pathname === "/admin/category")
  new Category(".category-tree", "category-tree-element", ".category-branch-text");
if(new RegExp('/admin/category/edit/\\d+').test(document.location.pathname))
  new Category(".category-edit-tree", "category-edit-tree-element", ".category-edit-branch-text");

