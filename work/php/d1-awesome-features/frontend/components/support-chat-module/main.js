class SupportChat {
  //Содержимое сценария
  JsonContent;
  //Блок диалога
  contentClass;
  //Блок ответов
  responseClass;

  constructor(path, contentClass, responseClass) {
    //Поиск блоков по селектору
    this.contentClass = document.querySelector(`.${contentClass}`);
    this.responseClass = document.querySelector(`.${responseClass}`);
    //Получение сценария из файла
    this.readJSON(path).then((res) => {
      this.JsonContent = res;
      this.sendMessage(0);
      this.getClickResp(this);
    });
  }

  //Обработка кликов на ответы
  getClickResp(classContext) {
    classContext.responseClass.addEventListener("click", function (event) {
      if (event.target.classList.contains("resp")) {
        classContext.sendUserMessage(event.target.innerText);
        classContext.sendMessage(event.target.dataset.next);
      }
    });
  }

  async readJSON(file) {
    let response = await fetch(file);

    if (response.ok) {
      return await response.json();
    }
  }

  getItemById(id) {
    return this.JsonContent[id];
  }

  sendMessage(id) {
    //Избавление от лишних запросов
    const item = this.getItemById(id);

    //Очистка при отправке начального сообщения
    if (id == 0) {
      while (this.contentClass.firstChild) {
        this.contentClass.removeChild(this.contentClass.firstChild);
      }
    }

    //Если содержимое сообщения объект
    if (typeof item["text"] === "object") {
      switch (item["text"]["type"]) {
        //Вывод ссылки
        case "link":
          this.contentClass.innerHTML += `<a href=${item["text"]["url"]} class='bot-msg'> ${item["text"]["text"]}</a>`;
          break;
        //Запрос с API
        case "ajax":
          this.readJSON(item["text"]["url"]).then((res) => {
            let resp = res;
            this.contentClass.innerHTML += `<p class='bot-msg'>${resp["resp"]}</p>`;
            //Скрол до конца диалога по приходу ответа
            this.contentClass.scrollTo(0, this.contentClass.scrollHeight);
          });

          break;
      }
    } else {
      //Иначе вывод текст
      this.contentClass.innerHTML += `<p class='bot-msg'>${item["text"]}</p>`;
    }
    //Вывод ответов
    this.addResponse(id);
    //Скрол до конца диалога
    this.contentClass.scrollTo(0, this.contentClass.scrollHeight);
  }

  sendUserMessage(text) {
    this.contentClass.innerHTML += `<p class='user-msg'>${text}</p>`;
  }

  //Вывод ответов
  addResponse(id) {
    //Очистка блока
    while (this.responseClass.firstChild) {
      this.responseClass.removeChild(this.responseClass.firstChild);
    }

    //Вывод
    this.getItemById(id)["options"].forEach((element) => {
      this.responseClass.innerHTML += `<p class='resp' data-next='${element["next_step"]}'>${element["text"]}</p>`;
    });
  }
}
