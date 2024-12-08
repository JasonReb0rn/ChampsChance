function updateBreadcrumbs() {
    var path = window.location.pathname;
    var breadcrumbsContainer = document.querySelector(".breadcrumbs-container");
    var breadcrumbsCategory = document.getElementById("breadcrumbs-category");
    var breadcrumbsPage = document.getElementById("breadcrumbs-page");
  
    // If on the homepage or no specific page, remove breadcrumbs container
    if (path.includes("home.php") || path === "/" || path === "") {
      breadcrumbsContainer.remove();
      return; // Exit the function early
    }
  
    // If NOT an article page, remove breadcrumbs-page
    if (!path.includes("articles")) {
      breadcrumbsPage.remove();
  
      // Set breadcrumbs-category based on current page
      var category = "";
      var originalPageName = path.split("/").pop();
      // If not adopt or blog, dynamically generate category based on page name
      category = originalPageName.replace(".php", "").replace(/[-_]/g, " ");
      category = category.replace(/\b\w/g, function (char) {
          return char.toUpperCase();
      });
      
      breadcrumbsCategory.querySelector("a").textContent = category;
      breadcrumbsCategory.querySelector("a").href = originalPageName;
  
    } else {
      // ARTICLE PAGE
      breadcrumbsCategory.querySelector("a").textContent = 'Blog';
      breadcrumbsCategory.querySelector("a").href = '../blog.php';
  
      // Get article title and set it as breadcrumbs-page
      var articleTitleElement = document.querySelector(".article-title");
  
      if (articleTitleElement) {
        var articleTitle = articleTitleElement.textContent.trim();
        breadcrumbsPage.textContent = articleTitle;
      }
    }
  }
  
  document.addEventListener("DOMContentLoaded", function() {
    updateBreadcrumbs();
  });