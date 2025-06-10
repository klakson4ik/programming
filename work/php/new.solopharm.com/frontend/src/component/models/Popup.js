const blockName = 'b-popup';

export class Popup {
    constructor(block = false) {
      this.block = block || document.querySelector(`.${blockName}`);
      this.container = this.block.querySelector(`.${blockName}__container`);
      this.btnClose = this.block.querySelector(`.${blockName}__window-close`);
      this.body = document.body;
      this.activeClass = `${blockName}--active`;
      this.video = this.block.querySelector(`.${blockName}__video-wrap > iframe`);
      this.panorama = this.block.querySelector(`.${blockName}__panorama`);
      this.header = document.querySelector('.b-wrapper__header');
    }
  
    onActive(btn) {
      btn.addEventListener('click', () => {
        this.open();
      }, true);
    }
  
    onClose() {
      this.container.addEventListener('click', () => {
        this.close();
      }, true);
      this.btnClose.addEventListener('click', () => {
        this.close();
      }, true);
    }
  
    close() {
      this.block.classList.remove(this.activeClass);
      this.body.classList.remove('disable-scroll');
      this.header.style.zIndex = 3;
  
      if (this.video) {
        this.video.contentWindow.postMessage('{"event": "command", "func": "pauseVideo", "args": ""}', '*');
      }
  
      if (this.panorama) {
        this.stopPanorama();
      }
    }
  
    open() {
      this.block.classList.add(this.activeClass);
      this.body.classList.add('disable-scroll');
      this.header.style.zIndex = 0;
  
      if (this.video) {
        this.video.contentWindow.postMessage('{"event": "command", "func": "playVideo", "args": ""}', '*');
      }
  
      if (this.panorama) {
        this.renderPanorama();
      }
  
      this.onClose();
    }
  
    renderPanorama() {
      const link = this.panorama.dataset.src;
  
      this.panorama.setAttribute('src', link);
    }
  
    stopPanorama() {
      this.panorama.removeAttribute('src');
    }
  }
