(function () {
  const currentScript = document.currentScript;
  const urlTujuan = currentScript.getAttribute("data-url") || "https://support.unsub.ac.id/id/ticket";
  const kategori = currentScript.getAttribute("data-category") || "";


  const button = document.createElement("div");
  button.id = "customFloatingButton";
  button.innerHTML = `
    <svg width="24" height="24" viewBox="0 0 60 61" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M52.1249 7.625H7.87488L6.03113 9.53125V52.0997L9.21252 53.4112L19.7302 41.9375H52.1249L53.9686 40.0312V9.53125L52.1249 7.625ZM50.2811 38.125H18.1446L15.7634 40.7223L9.71863 47.3179V11.4375H50.2811V38.125Z" fill="#ffffff"/>
    </svg>
    <span style="margin-left: 8px;">Butuh Bantuan ?</span>
  `;

  button.style.position = "fixed";
  button.style.bottom = "20px";
  button.style.right = "20px";
  button.style.padding = "12px 20px";
  button.style.backgroundColor = "#39a1dd";
  button.style.color = "white";
  button.style.borderRadius = "999px"; // pill shape
  button.style.display = "flex";
  button.style.alignItems = "center";
  button.style.boxShadow = "0 4px 10px rgba(0,0,0,0.3)";
  button.style.cursor = "pointer";
  button.style.zIndex = "9999";
  button.style.fontSize = "16px";
  button.style.userSelect = "none";
  button.title = "Butuh Bantuan ?";

  button.addEventListener("click", () => {
    window.open(urlTujuan+`?category=${kategori}`, "_blank");
  });

  document.body.appendChild(button);
})();
