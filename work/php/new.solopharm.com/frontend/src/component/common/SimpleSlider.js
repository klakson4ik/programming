export default class SimpleSlider {
  constructor(blockName, slider = `${blockName}__slider`, slide = `${blockName}__slide`, btnNext = `${blockName}__nav-next`, btnPrev = `${blockName}__nav-prev`, slideActive = `${blockName}__slide--active`) {
    this.block = document.querySelector(`.${blockName}`);
    if (!this.block) return false;
    this.slider = this.block.querySelector(`.${slider}`);
    this.sliders = this.slider.querySelectorAll(`.${slide}`);
    this.btnNext = this.block.querySelector(`.${btnNext}`);
    this.btnPrev = this.block.querySelector(`.${btnPrev}`);
    this.slideActive = this.block.querySelector(`.${slideActive}`);
    this.currentSlide = this.sliders[0];
    this.currentShift = 0;
  }

  onActive(callback = false) {
    this.btnNext.addEventListener('click', () => {
      const id = this.next();

      if (callback) callback(id);
    });
    this.btnPrev.addEventListener('click', () => {
      const id = this.prev();

      if (callback) callback(id);
    });
  }

  next() {
    let nextSlide = this.currentSlide.nextElementSibling;

    if (!nextSlide) {
      nextSlide = this.sliders[0];
      this.currentShift = 0;
    } else {
      this.currentShift += this.currentSlide.offsetWidth;
    }

    this.currentSlide = nextSlide;
    this.slider.style.right = `${this.currentShift}px`;
    return this.currentSlide.dataset.id;
  }

  prev() {
    let nextSlide = this.currentSlide.previousElementSibling;

    if (!nextSlide) {
      nextSlide = this.sliders[this.sliders.length - 1];
      this.currentShift = this.currentSlide.offsetWidth * (this.sliders.length - 1);
    } else {
      this.currentShift -= this.currentSlide.offsetWidth;
    }

    this.currentSlide = nextSlide;
    this.slider.style.right = `${this.currentShift}px`;
    return this.currentSlide.dataset.id;
  }
}
