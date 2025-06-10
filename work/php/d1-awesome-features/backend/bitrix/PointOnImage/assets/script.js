window.addEventListener('load', () => {

    let dots = new Array;


    if (document.querySelector('.dots input[type="hidden"]').value != "") {
        dots = JSON.parse(document.querySelector('.dots input[type="hidden"]').value);

        dots = dots.filter(function (el) {
            return el != null;
        });


        dots.forEach(function (element, i) {
            document.querySelector(".modal .list").innerHTML += "<span id=\"span" + Number(i) + "\" >" + Number(i + 1) + " (" + element[0] + "," + element[1] + ")</span><span data-dotid=\"" + i + "\" class=\"adm-fileinput-item-panel-btn adm-btn-del\">&nbsp;</span>"
            document.querySelector(".modal .area").innerHTML += "<div style=\"top:" + element[1] + "%;left:" + element[0] + "%;\" id=\"dot" + Number(i + 1) + "\" class=\"dot\">" + Number(i + 1) + "</div>";
        });
    }


    document.addEventListener('click', function (e) {
        if (e.target.closest(".open-modal")) {
            e.target.closest(".dots").querySelector(".modal").style.display = "block";
            e.target.closest(".dots").querySelector(".shadow").style.display = "block";
        }

        if (e.target.closest(".modal img")) {
            imgWidth = e.target.closest(".modal img").offsetWidth / 100;
            imgHeight = e.target.closest(".modal img").offsetHeight / 100;

            dotX = Math.ceil(e.
                offsetX
                 / imgWidth)

            dotY = Math.ceil(e.
                offsetY
                 / imgHeight)

            console.log(e);

            document.querySelector(".modal .list").innerHTML += "<span id=\"span" + dots.length + "\" >" + (dots.length + 1) + " (" + dotY + "," + dotX + ")</span><span data-dotid=\"" + dots.length + "\" class=\"adm-fileinput-item-panel-btn adm-btn-del\">&nbsp;</span>"
            dots.push([dotX, dotY]);
            e.target.closest(".modal .area").innerHTML += "<div style=\"top:" + dotY + "%;left:" + dotX + "%;\" id=\"dot" + dots.length + "\" class=\"dot\">" + dots.length + "</div>";
        }

        if (e.target.closest(".shadow")) {
            e.target.closest(".dots").querySelector(".modal").style.display = "none";
            e.target.closest(".dots").querySelector(".shadow").style.display = "none";
        }

        if (e.target.closest(".adm-btn-del")) {
            e.target.closest(".adm-btn-del").remove();
            delete dots[e.target.closest(".adm-btn-del").dataset.dotid];
            document.querySelector("#span" + e.target.closest(".adm-btn-del").dataset.dotid).remove();
            document.querySelector("#dot" + (Number(e.target.closest(".adm-btn-del").dataset.dotid) + 1)).remove();
        }

        if (e.target.closest(".popup-window-button-accept")) {
            e.target.closest(".dots").querySelector(".modal").style.display = "none";
            e.target.closest(".dots").querySelector(".shadow").style.display = "none";
        }

        if (e.target.closest(".popup-window-button-link-cancel")) {
            dots = [];
            document.querySelector(".modal .list").innerHTML = "";

            if (document.querySelectorAll(".modal .dot")) {
                document.querySelectorAll(".modal .dot").forEach(element => {
                    element.remove();
                });
            }
        }

        dots = dots.filter(function (el) {
            return el != null;
        });

        document.querySelector('.dots input[type="hidden"]').value = JSON.stringify(dots);

    });

});

