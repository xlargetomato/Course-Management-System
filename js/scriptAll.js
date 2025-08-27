const LINKS = document.querySelectorAll(".link");
//// Index >> mainmenu = (0),course = (1),leacture = (2)||,assign = (3),,controlpanel = (4),about = (6),
////////////////////////////////////
// const lectureList = document.querySelector(".slidedown");
const listA = document.querySelector(".listA");
const listchilds = document.querySelectorAll(".listA li");
const HUM = document.querySelector(".HUM");
const sidebar = document.querySelector(".sidebar");
const page = document.querySelector(".page");
const anihover = document.querySelectorAll(".ani-hover");
///////////1 => <div>اضافه المحاضرات</div>
///////////2 => <div>إداره المحاضرات</div>
///////////3 => <div>إداره التكاليف</div>
///////////4 => <div>إداره المقررات</div>
///////////5 => <div>إداره المستخدمين</div>

//////////////////
//////////////////
const modal = document.getElementById("photoModal");
const modalImage = document.getElementById("modalImage");
const closeModal = document.querySelector(".close");
// LINKS[6].addEventListener("click", () => {
//   // URL of the photo
//   const photoURL = "content-and-imgs/tableo.png";

//   // Show the modal and set the image source
//   modal.style.display = "block";
//   modalImage.src = photoURL;
// });

// Close the modal
closeModal.addEventListener("click", () => {
  modal.style.display = "none";
});

// Close modal when clicking outside the image
window.addEventListener("click", (e) => {
  if (e.target === modal) {
      modal.style.display = "none";
  }
});

LINKS[2].onclick = () => {
  listA.classList.toggle("BLOCK");

  setTimeout(() => {
    listA.classList.toggle("translate");
  });
};

LINKS[0].addEventListener("click", () => {
  window.location = "/";
});

LINKS[1].addEventListener("click", () => {
  window.location = "/course";
});

LINKS[3].addEventListener("click", () => {
  window.location = "/assignments";
});

LINKS[4].addEventListener("click", () => {
  window.location = "/finalprojects";
});

LINKS[5].addEventListener("click", () => {
  window.location = "/controlpanel";
});

HUM.addEventListener("click", () => {
  sidebar.classList.toggle("BLOCK");
  HUM.classList.toggle("move-right");
  page.classList.toggle("opacity-color");

  setTimeout(() => {
    sidebar.classList.toggle("translate");
  });
});

// Close sidebar when clicking outside
document.addEventListener("click", (event) => {
  const isClickInsideSidebar = sidebar.contains(event.target);
  const isClickOnHUM = HUM.contains(event.target);

  // If the click is outside the sidebar and not on HUM
  if (!isClickInsideSidebar && !isClickOnHUM) {
    if (sidebar.classList.contains("BLOCK")) {
      sidebar.classList.remove("BLOCK");
      HUM.classList.remove("move-right");
      page.classList.remove("opacity-color");
      sidebar.classList.remove("translate");
    }
  }
});
// LINKS[99].addEventListener("click", () => {
//   window.location = "index.html";
// });
////////////////////////////////////////////////////// DARK MODE
// SOOOOOOOOOOOOOOOOOOOOOON
///////////////////////////////////////
// LINKS[5].onclick = () => {
//   listB.classList.toggle("BLOCK");

//   setTimeout(() => {
//     listB.classList.toggle("translate");
//   });
// };
// const themeBtnDark = document.querySelector(".themeChange-DARK");
// const themeBtnMain = document.querySelector(".themeChange-MAIN");
// const rootPick = document.querySelector(":root");
// const rootStyles = getComputedStyle(rootPick);
// const main1 = rootStyles.getPropertyValue("--main1");
// const main2 = rootStyles.getPropertyValue("--main2");
// const listB = document.querySelector(".listB");

// themeBtnDark.addEventListener("click", () => {#FEE715
//   rootPick.style.setProperty("--main1", "#FEE715");
//   rootPick.style.setProperty("--main2", "#101820");
//   rootPick.style.setProperty("--hover1", "--hover1-Dark");
// });
// themeBtnMain.addEventListener("click", () => {
//   rootPick.style.setProperty("white", "--main1");
//   rootPick.style.setProperty("black", "--main2");
// });
