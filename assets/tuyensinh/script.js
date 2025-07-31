const header_img = document.querySelector(".header-img");
const header_img_icon = header_img.querySelector("img");
header_img_icon.addEventListener("click", function () {
  location.reload();
});

const bt_bars = document.querySelector(".header-bars");
const icon_bars = bt_bars.querySelector("i");
const header_list_down = document.querySelector(".header-list-down");

let menuIsOpen = false;

const click_bt_bars = () => {
  if (menuIsOpen) {
    closeMenu();
  } else {
    openMenu();
  }
};

function openMenu() {
  icon_bars.className = "fa-solid fa-xmark fa-2xl";
  header_list_down.style.display = "flex";
  document.body.style.overflow = "hidden";
  menuIsOpen = true;

  window.addEventListener("resize", handleResize);
}

function closeMenu() {
  icon_bars.className = "fa-solid fa-bars fa-2xl";
  header_list_down.style.display = "none";
  document.body.style.overflow = "auto";
  menuIsOpen = false;

  window.removeEventListener("resize", handleResize);
}

function handleResize() {
  if (window.innerWidth > 980 && menuIsOpen) {
    closeMenu();
  }
}

bt_bars.addEventListener("click", click_bt_bars);

function initSearch() {
  const searchIcon = document.querySelector(".header-search__icon i");
  const searchInput = document.querySelector(".header-search__input");
  const searchContainer = document.querySelector(".header-search__icon");

  if (searchIcon && searchInput) {
    searchIcon.addEventListener("click", function (e) {
      e.preventDefault();
      e.stopPropagation();

      const searchQuery = searchInput.value.trim();

      if (searchQuery) {
        const searchURL = `https://www.google.com/search?q=${encodeURIComponent(
          searchQuery
        )}`;
        window.open(searchURL, "_blank");
      } else {
        alert("Vui lòng nhập từ khóa tìm kiếm!");
      }
    });

    if (searchContainer) {
      searchContainer.addEventListener("click", function (e) {
        e.preventDefault();

        const searchQuery = searchInput.value.trim();
        if (searchQuery) {
          const searchURL = `https://www.google.com/search?q=${encodeURIComponent(
            searchQuery
          )}`;
          window.open(searchURL, "_blank");
        } else {
          alert("Vui lòng nhập từ khóa tìm kiếm!");
        }
      });
    }

    searchInput.addEventListener("keypress", function (e) {
      if (e.key === "Enter") {
        e.preventDefault();

        const searchQuery = searchInput.value.trim();
        if (searchQuery) {
          const searchURL = `https://www.google.com/search?q=${encodeURIComponent(
            searchQuery
          )}`;
          window.open(searchURL, "_blank");
        } else {
          alert("Vui lòng nhập từ khóa tìm kiếm!");
        }
      }
    });

    searchIcon.addEventListener("mouseenter", function () {
      this.style.cursor = "pointer";
      this.style.transform = "scale(1.1)";
    });

    searchIcon.addEventListener("mouseleave", function () {
      this.style.transform = "scale(1)";
    });
  }
}

document.addEventListener("DOMContentLoaded", function () {
  initSearch();
});

window.addEventListener("load", function () {
  setTimeout(initSearch, 100);
});

function performSearch() {
  const searchInput = document.getElementById("searchInput");
  const searchQuery = searchInput ? searchInput.value.trim() : "";

  if (searchQuery) {
    const searchURL = `https://www.google.com/search?q=${encodeURIComponent(
      searchQuery
    )}`;
    window.open(searchURL, "_blank");
  } else {
    alert("Vui lòng nhập từ khóa tìm kiếm!");
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("searchInput");
  if (searchInput) {
    searchInput.addEventListener("keypress", function (e) {
      if (e.key === "Enter") {
        e.preventDefault();
        performSearch();
      }
    });
  }
});

const suggestionForm = document.querySelector(".suggestion-form");
const styleLabelInput = {
  top: "43px",
  color: "#999",
  transition: "0.25s ease",
  left: "21px",
  backgroundColor: "#ffff",
};
const styleLabelInputed = {
  top: "0%",
  color: "#00377a",
  transition: "0.25s ease",
  left: "21px",
  backgroundColor: "#e8f0fe",
};
const styleInput = {
  borderColor: "black",
  color: "black",
  backgroundColor: "#ffff",
};
const styleInputed = {
  borderColor: "#00377a",
  color: "black",
  backgroundColor: "#e8f0fe",
};

const afterInputedData = (inputItem, labelItem) => {
  Object.assign(labelItem.style, styleLabelInputed);
  Object.assign(inputItem.style, styleInputed);
};
const beforeInputedData = (inputItem, labelItem) => {
  Object.assign(labelItem.style, styleLabelInput);
  Object.assign(inputItem.style, styleInput);
};

const notifications = document.querySelector(".list-notification");
const notification_success = notifications.querySelector(
  ".success-notification"
);
const notification_error = notifications.querySelector(".error-notification");

const btn_circle_up = document.querySelector(".btn-top");

window.onscroll = function () {
  if (
    document.body.scrollTop > 200 ||
    document.documentElement.scrollTop > 200
  ) {
    btn_circle_up.style.display = "block";
  } else {
    btn_circle_up.style.display = "none";
  }
};

function scrollToTop() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

btn_circle_up.addEventListener("click", scrollToTop);

function cuonDenViTriForm() {
  const suggestionSection = document.querySelector(".suggestion-section");
  if (suggestionSection) {
    suggestionSection.scrollIntoView({ behavior: "smooth" });
  }
}

async function getMajorSuggestions() {
  const admissionMethod = document.getElementById("admission-method").value;
  const subjectNames = document.querySelectorAll(".subject-name");
  const subjectScores = document.querySelectorAll(".subject-score");

  const scores = [];
  for (let i = 0; i < subjectNames.length; i++) {
    const name = subjectNames[i].value.trim();
    const score = parseFloat(subjectScores[i].value);

    if (name && !isNaN(score) && score >= 0 && score <= 10) {
      scores.push({
        subject_name: name,
        score: score,
      });
    }
  }

  if (scores.length === 0) {
    showError("Vui lòng nhập ít nhất một môn học và điểm số hợp lệ (0-10)");
    return;
  }

  const resultsContainer = document.getElementById("results-container");
  const suggestionResults = document.getElementById("suggestion-results");

  suggestionResults.style.display = "block";
  resultsContainer.innerHTML =
    '<div class="loading">Đang tìm kiếm ngành học phù hợp...</div>';

  setTimeout(() => {
    suggestionResults.scrollIntoView({
      behavior: "smooth",
      block: "start",
      inline: "nearest",
    });
  }, 100);

  try {
    const response = await fetch(
      "http://127.0.0.1:8000/api/suggestions/by-score",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          admission_method: admissionMethod,
          scores: scores,
        }),
      }
    );

    if (!response.ok) {
      throw new Error(`HTTP Error ${response.status}: ${response.statusText}`);
    }

    const data = await response.json();

    if (data.data && Array.isArray(data.data) && data.data.length > 0) {
      displaySuggestions(data.data);
      setTimeout(() => {
        suggestionResults.scrollIntoView({
          behavior: "smooth",
          block: "start",
          inline: "nearest",
        });
      }, 200);
    } else {
      showError(
        "Không tìm thấy ngành học phù hợp với điểm số của bạn. Vui lòng thử lại với điểm số khác."
      );
    }
  } catch (error) {
    if (
      error.message.includes("Failed to fetch") ||
      error.message.includes("NetworkError")
    ) {
      showDemoResults(scores);
    } else {
      showError(
        `Có lỗi xảy ra khi tìm kiếm ngành học: ${error.message}. Vui lòng thử lại sau.`
      );
    }
  }
}

function displaySuggestions(majors) {
  const resultsContainer = document.getElementById("results-container");
  const suggestionResults = document.getElementById("suggestion-results");

  let html = "";
  majors.forEach((major, index) => {
    html += `
            <div class="major-suggestion">
                <div class="major-header">
                    <div class="major-name">${major.name || "Ngành học"}</div>
                </div>
                <div class="major-code">Mã ngành: ${major.code || "N/A"}</div>
                <div class="major-description">${
                  major.description || "Mô tả ngành học sẽ được hiển thị ở đây."
                }</div>
                ${
                  major.matched_criterion
                    ? `<div class="matched-criterion">Tiêu chí phù hợp: ${major.matched_criterion}</div>`
                    : ""
                }
                <div class="major-actions">
                    <button class="major-detail-btn" onclick="showMajorDetail('${
                      major.id || ""
                    }', '${major.name || ""}')">
                        <i class="fa-solid fa-info-circle"></i>
                        Chi tiết
                    </button>
                    <button class="major-apply-btn" onclick="applyForMajor('${
                      major.id || ""
                    }', '${major.name || ""}')">
                        <i class="fa-solid fa-paper-plane"></i>
                        Đăng ký
                    </button>
                </div>
            </div>
        `;
  });

  resultsContainer.innerHTML = html;

  suggestionResults.classList.add("show");
  suggestionResults.style.display = "block";

  console.log(`Đã tìm thấy ${majors.length} ngành học phù hợp!`);
}

function showError(message) {
  const resultsContainer = document.getElementById("results-container");
  const suggestionResults = document.getElementById("suggestion-results");

  resultsContainer.innerHTML = `
        <div class="error-message">
            <i class="fa-solid fa-exclamation-triangle"></i>
            <span>${message}</span>
        </div>
    `;

  suggestionResults.style.display = "block";
  suggestionResults.classList.add("show");
}

function showMajorDetail(majorId, majorName) {
  alert(
    `Chi tiết ngành học: ${majorName}\n\nChức năng này sẽ được phát triển thêm.`
  );
}

function applyForMajor(majorId, majorName) {
  alert(
    `Đăng ký ngành học: ${majorName}\n\nChức năng này sẽ được phát triển thêm.`
  );
}

document.addEventListener("DOMContentLoaded", function () {
  const scoreInputs = document.querySelectorAll(".subject-score");

  scoreInputs.forEach((input) => {
    input.addEventListener("input", function () {
      const value = parseFloat(this.value);
      if (value < 0) {
        this.value = 0;
      } else if (value > 10) {
        this.value = 10;
      }
    });
  });
});

function showDemoResults(scores) {
  const resultsContainer = document.getElementById("results-container");
  const suggestionResults = document.getElementById("suggestion-results");

  const demoMajors = generateDemoMajors(scores);

  let html = `
        <div class="demo-notice">
            <i class="fa-solid fa-info-circle"></i>
            <strong>Chế độ Demo:</strong> Backend chưa chạy, đây là kết quả mẫu
        </div>
    `;

  demoMajors.forEach((major, index) => {
    html += `
            <div class="major-suggestion">
                <div class="major-header">
                    <div class="major-name">${major.name}</div>
                </div>
                <div class="major-code">Mã ngành: ${major.code}</div>
                <div class="major-description">${major.description}</div>
                <div class="matched-criterion">Tiêu chí phù hợp: ${major.matched_criterion}</div>
                <div class="major-actions">
                    <button class="major-detail-btn" onclick="showMajorDetail('${major.id}', '${major.name}')">
                        <i class="fa-solid fa-info-circle"></i>
                        Chi tiết
                    </button>
                    <button class="major-apply-btn" onclick="applyForMajor('${major.id}', '${major.name}')">
                        <i class="fa-solid fa-paper-plane"></i>
                        Đăng ký
                    </button>
                </div>
            </div>
        `;
  });

  resultsContainer.innerHTML = html;
  suggestionResults.classList.add("show");
  suggestionResults.style.display = "block";

  console.log("Hiển thị kết quả demo thành công");
}

function generateDemoMajors(scores) {
  const demoMajors = [
    {
      id: 1,
      name: "Công nghệ thông tin",
      code: "7480201",
      description:
        "Ngành học về phát triển phần mềm, hệ thống thông tin, và mạng máy tính.",
      matched_criterion: "Xét tuyển khối A00 - Điểm thi THPT 2024",
    },
    {
      id: 2,
      name: "Quản trị kinh doanh",
      code: "7340101",
      description:
        "Ngành học về quản lý hoạt động kinh doanh, marketing, và nhân sự.",
      matched_criterion: "Xét tuyển khối A01 - Điểm thi THPT 2024",
    },
  ];

  const filteredMajors = demoMajors.filter((major) => {
    const mathScore =
      scores.find((s) => s.subject_name.toLowerCase().includes("toán"))
        ?.score || 0;
    const physicsScore =
      scores.find((s) => s.subject_name.toLowerCase().includes("lý"))?.score ||
      0;
    const chemistryScore =
      scores.find((s) => s.subject_name.toLowerCase().includes("hóa"))?.score ||
      0;
    const englishScore =
      scores.find((s) => s.subject_name.toLowerCase().includes("anh"))?.score ||
      0;

    if (major.name.includes("Công nghệ thông tin")) {
      return mathScore >= 8.0 && physicsScore >= 7.5 && chemistryScore >= 7.5;
    } else if (major.name.includes("Quản trị kinh doanh")) {
      return mathScore >= 7.5 && physicsScore >= 7.0 && englishScore >= 8.0;
    }

    return true;
  });

  return filteredMajors.length > 0 ? filteredMajors : demoMajors;
}
