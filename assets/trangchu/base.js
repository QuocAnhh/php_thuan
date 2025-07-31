window.addEventListener("load", function () {
  var loader = document.querySelector(".loading");
  setTimeout(function () {
    setTimeout(function () {
      document.documentElement.scrollTo(0, 0);
    }, 500);
    setTimeout(function () {
      loader.style = "display: none;";
    }, 1000);
  }, 0);

  const sliderMain = document.querySelector(".slider-main");
  const sliderItems = document.querySelectorAll(".slider-item");
  const prevBtn = document.querySelector(".slider-prev");
  const nextBtn = document.querySelector(".slider-next");
  const dot = document.querySelectorAll(".slider-dot");
  var slideIndex = 0;
  const slideItemWidth = sliderItems[0].offsetWidth;
  const slideLength = sliderItems.length;
  var posX = 0;

  nextBtn.addEventListener("click", function () {
    changeSlide(1);
  });

  prevBtn.addEventListener("click", function () {
    changeSlide(-1);
  });
  autoNextSlide();

  function changeSlide(direction) {
    if (direction === 1) {
      if (slideIndex === slideLength - 1) {
        posX = 0;
        slideIndex = 0;
        sliderMain.style = `transform: translateX(${posX}px)`;
        return;
      }
      slideIndex++;
      posX = posX - slideItemWidth;
      sliderMain.style = `transform: translateX(${posX}px)`;
    } else if (direction === -1) {
      if (slideIndex === 0) {
        slideIndex = slideLength - 1;
        posX = -slideItemWidth * (slideLength - 1);
        sliderMain.style = `transform: translateX(${posX}px)`;
        return;
      }
      slideIndex--;
      posX = posX + slideItemWidth;
      sliderMain.style = `transform: translateX(${posX}px)`;
    }
  }

  function autoNextSlide() {
    setInterval(function () {
      changeSlide(1);
    }, 5000);
  }

  var toTopBtn = document.querySelector(".to-top");
  var chatBtn = document.querySelector("button.chat-btn");

  function scrollFunction() {
    if (
      document.body.scrollTop > 200 ||
      document.documentElement.scrollTop > 200
    ) {
      toTopBtn.classList.add("show");
      chatBtn.style = "bottom: 84px;";
    } else {
      toTopBtn.classList.remove("show");
      chatBtn.style = "bottom: 24px;";
    }
  }

  function topFunction() {
    document.body.scrollTo(0, 0);
    document.documentElement.scrollTo(0, 0);
  }

  toTopBtn.onclick = function () {
    topFunction();
  };

  var header = document.querySelector("header");
  var headerLogo = document.querySelector(".header__logo");
  function scrollFunction2() {
    if (
      document.body.scrollTop > 50 ||
      document.documentElement.scrollTop > 50
    ) {
      header.classList.add("fixed");
      headerLogo.style = "display: none;";
    } else {
      header.classList.remove("fixed");
      headerLogo.style = "display: block;";
    }
  }
  window.onscroll = function () {
    scrollFunction();
    scrollFunction2();
  };

  const notiList = document.querySelectorAll(".program__notifications");
  const notiItems = [];
  notiItems[0] = notiList[0].children;
  notiItems[1] = notiList[1].children;
  const seeMoreBtn = document.querySelectorAll("button.see-more");
  function getHeight(arr, n) {
    let h = 0;
    for (let i = 0; i < n; i++) {
      if (i < arr.length) {
        h += arr[i].offsetHeight;
      }
    }
    return h;
  }

  let n = 3;
  for (let i = 0; i < notiList.length; i++) {
    let notiListHeight = getHeight(notiItems[i], n);
    notiList[i].style = `height: ${notiListHeight}px; overflow: hidden;`;

    seeMoreBtn[i].onclick = function () {
      seeMoreBtn[i].innerHTML = "Xem thêm";
      n += 3;
      notiListHeight = getHeight(notiItems[i], n);
      notiList[i].style = `height: ${notiListHeight}px; overflow: hidden;`;
      if (n >= notiItems[i].length) {
        seeMoreBtn[i].innerHTML = "Ẩn bớt";
        n = 0;
      }
    };
  }
  const sideInfor = document.querySelector(".side-infor");
  const swipeBtn = document.querySelector(".swipe-left-btn");
  const menuBtn = document.querySelector(".menu-icon");
  const menu = document.querySelector(".header__menu");
  if (
    document.body.clientWidth < 739 ||
    document.documentElement.clientWidth < 739
  ) {
    swipeBtn.onclick = function () {
      sideInfor.classList.toggle("fixed");

      swipeBtn.classList.toggle("swipe-left-btn");
      swipeBtn.classList.toggle("swipe-right-btn");
    };
    menuBtn.onclick = function () {
      menu.classList.toggle("menu-show");
    };
  }

  wow = new WOW({
    boxClass: "wow",
    animateClass: "animate__animated",
    offset: 0,
    mobile: true,
    live: true,
  });
  wow.init();
});

let currentUser = null;
let isLoginMode = true;

function checkAuthStatus() {
  const token = localStorage.getItem("auth_token");
  const user = localStorage.getItem("user");

  if (token && user) {
    currentUser = JSON.parse(user);
    showUserInfo();
  }
}

function toggleAuth() {
  const loginForm = document.getElementById("loginForm");
  const registerForm = document.getElementById("registerForm");
  const toggleBtn = document.getElementById("toggleBtn");

  isLoginMode = !isLoginMode;

  if (isLoginMode) {
    loginForm.style.display = "flex";
    registerForm.style.display = "none";
    toggleBtn.textContent = "Đăng ký";
  } else {
    loginForm.style.display = "none";
    registerForm.style.display = "flex";
    toggleBtn.textContent = "Đăng nhập";
  }
}

async function login() {
  const email = document.getElementById("loginEmail").value;
  const password = document.getElementById("loginPassword").value;
  const statusDiv = document.getElementById("loginStatus");

  if (!email || !password) {
    showStatus(statusDiv, "Vui lòng nhập đầy đủ thông tin", "error");
    return;
  }

  showStatus(statusDiv, "Đang đăng nhập...", "loading");

  try {
    const response = await fetch(
      // SỬA LẠI URL CHO ĐÚNG
      "https://5036e9f2c9f8.ngrok-free.app/btl-web/login",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ email, password }),
        // 'include' LÀ BẮT BUỘC để trình duyệt gửi và nhận cookie session
        credentials: "include",
      }
    );

    const data = await response.json();

    if (response.ok) {
      // response.ok là true khi status là 2xx
      // KHÔNG CẦN LƯU TOKEN NỮA
      // Trình duyệt đã tự động lưu session cookie
      // localStorage.setItem("auth_token", data.access_token);

      // Bạn vẫn có thể lưu thông tin user để hiển thị trên UI
      localStorage.setItem("user", JSON.stringify(data.data.user));
      currentUser = data.data.user;

      showStatus(statusDiv, "Đăng nhập thành công!", "success");
      setTimeout(() => {
        // Chuyển hướng hoặc cập nhật UI
        showUserInfo();
      }, 1000);
    } else {
      // Hiển thị lỗi từ server
      showStatus(statusDiv, data.data.message || "Đăng nhập thất bại", "error");
    }
  } catch (error) {
    // Lỗi mạng hoặc lỗi parse JSON
    console.error("Lỗi kết nối hoặc xử lý response:", error);
    showStatus(statusDiv, "Lỗi kết nối server", "error");
  }
}
async function register() {
  const name = document.getElementById("registerName").value;
  const email = document.getElementById("registerEmail").value;
  const password = document.getElementById("registerPassword").value;
  const statusDiv = document.getElementById("registerStatus");

  if (!name || !email || !password) {
    showStatus(statusDiv, "Vui lòng nhập đầy đủ thông tin", "error");
    return;
  }

  if (password.length < 8) {
    showStatus(statusDiv, "Mật khẩu phải có ít nhất 8 ký tự", "error");
    return;
  }

  showStatus(statusDiv, "Đang đăng ký...", "loading");

  try {
    const response = await fetch(
      "https://5036e9f2c9f8.ngrok-free.app/btl-web/register",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          name,
          email,
          password,
          password_confirmation: password,
        }),
      }
    );

    const data = await response.json();

    if (response.ok) {
      localStorage.setItem("auth_token", data.access_token);
      localStorage.setItem("user", JSON.stringify(data.user));
      currentUser = data.user;

      showStatus(statusDiv, "Đăng ký thành công!", "success");
      setTimeout(() => {
        showUserInfo();
      }, 1000);
    } else {
      const errorMessage = data.errors
        ? Object.values(data.errors).flat().join(", ")
        : data.message || "Đăng ký thất bại";
      showStatus(statusDiv, errorMessage, "error");
    }
  } catch (error) {
    showStatus(statusDiv, "Lỗi kết nối server", "error");
  }
}

async function logout() {
  const token = localStorage.getItem("auth_token");

  if (token) {
    try {
      await fetch("https://33243e422081.ngrok-free.app/api/logout", {
        method: "POST",
        headers: {
          Authorization: `Bearer ${token}`,
          "Content-Type": "application/json",
        },
      });
    } catch (error) {
      console.log("Logout error:", error);
    }
  }

  localStorage.removeItem("auth_token");
  localStorage.removeItem("user");
  currentUser = null;

  showAuthForms();
}

function showUserInfo() {
  document.getElementById("loginForm").style.display = "none";
  document.getElementById("registerForm").style.display = "none";
  document.getElementById("userInfo").style.display = "flex";
  document.getElementById("userName").textContent = currentUser.name;

  const adminBtn = document.getElementById("adminBtn");
  if (currentUser.is_admin) {
    adminBtn.style.display = "block";
  } else {
    adminBtn.style.display = "none";
  }
}

function showAuthForms() {
  document.getElementById("userInfo").style.display = "none";
  toggleAuth();
}

function showStatus(element, message, type) {
  element.textContent = message;
  element.className = `auth-status ${type}`;
}

function vaoTrangAdmin() {
  window.location.href = "./trangadmin-demo.html";
}

document.addEventListener("DOMContentLoaded", function () {
  checkAuthStatus();
});
