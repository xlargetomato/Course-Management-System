"use strict";

///////////////////
// Write Your Generator Function Here

var sidebarBox = document.querySelector("#box");
var sidebarBtn = document.querySelector("#btn");
var pageWrapper = document.querySelector("#main-content");

sidebarBtn.addEventListener("click", function (event) {
  if (this.classList.contains("active")) {
    this.classList.remove("active");
    sidebarBox.classList.remove("active");
  } else {
    this.classList.add("active");
    sidebarBox.classList.add("active");
  }
});

window.addEventListener("keydown", function (event) {
  if (sidebarBox.classList.contains("active") && event.keyCode === 27) {
    sidebarBtn.classList.remove("active");
    sidebarBox.classList.remove("active");
  }
});
////////////////////
let botn = document.querySelector("#buttonsq");
window.onscroll = function () {
  if (document.documentElement.scrollTop > 200) {
    botn.classList.add("showsq");
  } else {
    botn.classList.remove("showsq");
  }
};
botn.onclick = () =>
  document.documentElement.scroll({
    top: 0,
    behavior: "smooth",
  });

// let botn = document.querySelector("#buttonsq");
// window.onscroll(function () {
//   if (window.scrollY() > 300) {
//     botn.classList.add("showsq");
//   } else {
//     botn.classList.remove("showsq");
//   }
// });
// botn.addEventListener("click", function (e) {
//   e.preventDefault();
//   window.scrollX = 0;
// });
// let fontOne = document.querySelector(".font-one");
// let fontTwo = document.querySelector(".font-two");
// let fontThree = document.querySelector(".font-three");
// let fontfour = document.querySelector(".font-four");
// let fontfive = document.querySelector(".font-five");
// let fontsix = document.querySelector(".font-six");
// let exampleshow = document.querySelector(".example-show");

// fontOne.addEventListener("click", function fontone() {
//   exampleshow.classList.remove(
//     "franklin",
//     "georgia",
//     "Gill-Sans",
//     "Trebuchet-MS",
//     "Times-New-Roman"
//   );
//   exampleshow.classList.add("sans-serif");
// });
// fontTwo.addEventListener("click", function fonttwo() {
//   exampleshow.classList.remove(
//     "sans-serif",
//     "georgia",
//     "Gill-Sans",
//     "Trebuchet-MS",
//     "Times-New-Roman"
//   );
//   exampleshow.classList.add("franklin");
// });
// fontThree.addEventListener("click", function fontthree() {
//   exampleshow.classList.remove(
//     "sans-serif",
//     "franklin",
//     "Gill-Sans",
//     "Trebuchet-MS",
//     "Times-New-Roman"
//   );
//   exampleshow.classList.add("georgia");
// });
// fontfour.addEventListener("click", function fontfour() {
//   exampleshow.classList.remove(
//     "sans-serif",
//     "franklin",
//     "Trebuchet-MS",
//     "georgia",
//     "Times-New-Roman"
//   );
//   exampleshow.classList.add("Gill-Sans");
// });
// fontfive.addEventListener("click", function fontfive() {
//   exampleshow.classList.remove(
//     "sans-serif",
//     "franklin",
//     "Gill-Sans",
//     "georgia",
//     "Times-New-Roman"
//   );
//   exampleshow.classList.add("Trebuchet-MS");
// });
// fontsix.addEventListener("click", function fontsix() {
//   exampleshow.classList.remove(
//     "sans-serif",
//     "franklin",
//     "Gill-Sans",
//     "Trebuchet-MS",
//     "georgia"
//   );
//   exampleshow.classList.add("Times-New-Roman");
// });

const CSD = document.querySelectorAll("#CSD");
// const CSDA = document.querySelectorAll("#CSDA");
// const CSDB = document.querySelectorAll("#CSDB");
const CSDC = document.querySelectorAll("#CSDC");
const content = document.querySelectorAll(".item");
const tklf = document.querySelector("#llll");
const quizs = document.querySelector("#quizs");
const themes = document.querySelector("#themes");
////////////////LINKS//////////////////
// CSDB[0].addEventListener("click", function () {
//   window.location = "links/quiz/index";
// });

///////////////SIDE BAR ///////////////////
content[1].addEventListener("click", function () {
  for (var i = 0; i < CSD.length; i++) {
    CSD[i].classList.toggle("block");
  }
});
// tklf.addEventListener("click", function () {
//   for (var i = 0; i < CSDA.length; i++) {
//     CSDA[i].classList.toggle("block");
//   }
// });
// quizs.addEventListener("click", function () {
//   for (var i = 0; i < CSDB.length; i++) {
//     CSDB[i].classList.toggle("block");
//   }
// });
themes.addEventListener("click", function () {
  for (var i = 0; i < CSDC.length; i++) {
    CSDC[i].classList.toggle("block");
  }
});
//////////////////////////////////////////////
////slider
// document.getElementById("show-element").onclick = function () {
//   var element = document.getElementById("to-show");
//   if (element.className === "hide") {
//     element.className = "show";
//     document.getElementsByTagName("body")[0].className = "on";
//     document.getElementById("show-element").className = "active";
//   } else {
//     element.className = "hide";
//     document.getElementsByTagName("body")[0].className = "off";
//     document.getElementById("show-element").className = "";
//   }
// };
///////////////////////
/////////////////   Search   //////////////

// function myFunction() {
//   // Declare variables
//   let ul = document.getElementById("myUL");
//   let input, filter, li, a, i, txtValue;
//   input = document.getElementById("myInput");
//   filter = input.value.toUpperCase();
//   ul = document.getElementById("myUL");
//   li = ul.getElementsByTagName("li");

//   // Loop through all list items, and hide those who don't match the search query
//   for (i = 0; i < li.length; i++) {
//     a = li[i].getElementsByTagName("a")[0];
//     txtValue = a.textContent || a.innerText;
//     if (txtValue.toUpperCase().indexOf(filter) > -1) {
//       li[i].style.display = "";
//     } else {
//       li[i].style.display = "none";
//     }
//   }
// }
////////////////back end json for search

////////////////back end json for search
//////// add class on hover  ////////
////////////////////////////////////////////
let select = document.querySelector(".textsA h1");
select.onselectstart = () => false;
//IIFE
(function () {
  "use strict";

  var canvas,
    ctx,
    mousePos,
    points = [],
    maxDist = 200,
    colour = "0, 0, 0";

  function init() {
    //Add on load scripts
    canvas = document.getElementById("canvas");
    ctx = canvas.getContext("2d");
    canvas.addEventListener("mousemove", function (evt) {
      mousePos = getMousePos(canvas, evt);
    });
    resizeCanvas();
    generatePoints(80);
    pointFun();
    setInterval(pointFun, 16);
    window.addEventListener("resize", resizeCanvas, false);
  }
  //Particle constructor
  function point() {
    this.x = Math.random() * (canvas.width + maxDist) - maxDist / 2;
    this.y = Math.random() * (canvas.height + maxDist) - maxDist / 2;
    this.vx = Math.random() * 1 - 0.5;
    this.vy = Math.random() * 1 - 0.5;
    this.dia = Math.random() * 1 + 2;
    points.push(this);
  }
  //Point generator
  function generatePoints(amount) {
    var temp;
    for (var i = 0; i < amount; i++) {
      temp = new point();
    }
  }
  //Point drawer
  function draw(obj) {
    ctx.beginPath();
    ctx.fillStyle = "rgb(" + colour + ")";
    if (obj.dia) {
      ctx.arc(obj.x, obj.y, obj.dia, 0, 2 * Math.PI);
    } else {
      ctx.arc(obj.x, obj.y, 2, 0, 2 * Math.PI);
    }
    ctx.closePath();
    ctx.fill();
    //ctx.stroke();
  }
  //Updates point position values
  function update(obj) {
    obj.x += obj.vx;
    obj.y += obj.vy;
    if (obj.x > canvas.width + maxDist / 2) {
      obj.x = -(maxDist / 2);
    } else if (obj.xpos < -(maxDist / 2)) {
      obj.x = canvas.width + maxDist / 2;
    }
    if (obj.y > canvas.height + maxDist / 2) {
      obj.y = -(maxDist / 2);
    } else if (obj.y < -(maxDist / 2)) {
      obj.y = canvas.height + maxDist / 2;
    }
  }
  //
  function pointFun() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    if (mousePos) {
      collision(mousePos, maxDist * 2);
      draw(mousePos);
    }
    for (var i = 0; i < points.length; i++) {
      collision(points[i], maxDist);
      draw(points[i]);
      update(points[i]);
    }
  }

  function collision(obj, dist) {
    var temp;
    for (var i = 0; i < points.length; i++) {
      //Don't interact with self
      if (obj !== points[i]) {
        temp = Math.sqrt(
          Math.pow(obj.x - points[i].x, 2) + Math.pow(obj.y - points[i].y, 2)
        );
        if (temp < dist) {
          ctx.beginPath();
          ctx.moveTo(obj.x, obj.y);
          ctx.strokeStyle =
            "rgba(" +
            colour +
            "," +
            0.8 * Math.pow((dist - temp) / dist, 5) +
            ")";
          ctx.moveTo(obj.x, obj.y);
          ctx.lineTo(points[i].x, points[i].y);
          ctx.closePath();
          ctx.stroke();
        }
      }
    }
  }

  function resizeCanvas() {
    canvas.width = window.innerWidth - 20;
    canvas.height = window.innerHeight;
    pointFun();
  }

  function getMousePos(cvs, evt1) {
    var rect = cvs.getBoundingClientRect();
    return {
      x: evt1.clientX - rect.left,
      y: evt1.clientY - rect.top,
    };
  }

  //Execute when DOM has loaded
  document.addEventListener("DOMContentLoaded", init, false);
})();

////////////////////////////////////////////
