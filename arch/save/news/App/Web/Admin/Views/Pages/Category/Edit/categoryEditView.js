class CategoryEdit
{
  constructor(){
      this.tree = document.querySelector(".category-edit-tree");
      this.button = document.querySelector(".category-edit-change-btn")
      this.newText = document.querySelector(".category-edit-change-newtext")
      this.parentID = document.querySelector(".category-edit-form-parent");
      this.plus = this.tree.getElementsByClassName("category-edit-branch-plus")
      this.changeParent();
  };

  changeParent(){
    this.button.addEventListener("click", () => {
        this.tree.style.display = "block";
    })
    for(let i = 0; i < this.plus.length; ++i){
      this.plus[i].addEventListener("click", (e) => {
          let newText = e.currentTarget.parentNode.querySelector(".category-edit-branch-text").textContent
          this.tree.style.display = ""
          this.newText.textContent = "new parent: " + newText; 
          this.newText.style.display = "block"
          this.parentID.value = e.currentTarget.dataset.id
      })
    }  
  }
}
if(new RegExp('/admin/category/edit/\\d+').test(document.location.pathname))
  new CategoryEdit
