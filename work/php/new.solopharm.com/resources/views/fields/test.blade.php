<div id="a">
    <div id="f"
        style=" width: 506px;
height: 248px;
background-image: url('/images/map-world.png');
background-size: cover;
position: relative;
overflow:hidden;
">

        <div id="dot-test"
            style="
    width: 8px;
        height: 8px;
        background-color: black;
        border-radius: 20px;
        position: absolute;
        top: -20%;
        left: -20%;
    ">

        </div>
    </div>


</div>


<script>
    function ready() {

        document.querySelector('#dot-test').style.top = document.querySelector('#top').value + "%";
        document.querySelector('#dot-test').style.left = document.querySelector('#left').value + "%";


        document.querySelector("#f").onclick = function(event) {
            event = event || window.event;
            document.querySelector('#top').value = Math.round(event.offsetY / 2.48 - 2);
            document.querySelector('#left').value = Math.round(event.offsetX / 5 - 1);

            document.querySelector('#dot-test').style.top = Math.round(event.offsetY / 2.48 - 2) + "%";
            document.querySelector('#dot-test').style.left = Math.round(event.offsetX / 5 - 1) + "%";
        };
    }

    document.addEventListener("DOMContentLoaded", function() {
        ready();
    });
</script>
