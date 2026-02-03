function setAttrItemAndTag(attr, val) {
    document.documentElement.setAttribute(attr, val)
    localStorage.setItem(attr, val);
}

function lightDarkMode() {
    var lightDarkBtn = document.getElementById('light-dark-mode');
    lightDarkBtn.addEventListener('click', () => {
        const currentMode = document.documentElement.getAttribute("data-mode");

        if (currentMode === "light") {
            applyTheme("dark");
        } else {
            applyTheme("light");
        }
    })
}

function applyTheme(mode) {
    setAttrItemAndTag("data-mode", mode);
    setAttrItemAndTag("data-sidebar", mode);
    setAttrItemAndTag("data-topbar", mode);

    document.documentElement.classList.toggle("dark", mode === "dark");
}

function initTheme() {
    const savedMode = localStorage.getItem("data-mode");

    if (savedMode) {
        applyTheme(savedMode);
    } else {
        // Aucun choix utilisateur → on suit le thème du navigateur
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        applyTheme(prefersDark ? "dark" : "light");
    }

    lightDarkMode();
}

window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
    if (!localStorage.getItem("data-mode")) {
        applyTheme(e.matches ? "dark" : "light");
    }
});

initTheme();
