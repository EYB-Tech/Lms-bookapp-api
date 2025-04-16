document.addEventListener('dragstart', function (e) {
    e.preventDefault();
});

document.addEventListener('keydown', function (e) {
    if (e.ctrlKey && ['u', 'U', 'i', 'I', 'j', 'J'].includes(e.key)) {
        e.preventDefault();
    }
    if (e.key === 'F12') {
        e.preventDefault();
    }
});

document.addEventListener('contextmenu', function (e) {
    e.preventDefault();
});

let devtoolsOpen = false;
const threshold = 160;

// Function to check if the user is on mobile
const isMobileDevice = () => {
    const userAgent = navigator.userAgent || navigator.vendor || window.opera;
    return /android|iPhone|iPad|iPod|opera mini|blackberry|mobile/i.test(userAgent.toLowerCase());
};

const checkDevTools = () => {
    if (isMobileDevice()) {
        // Do nothing for mobile devices
        return;
    }

    const widthThreshold = window.outerWidth - window.innerWidth > threshold;
    const heightThreshold = window.outerHeight - window.innerHeight > threshold;

    if (widthThreshold || heightThreshold) {
        if (!devtoolsOpen) {
            document.body.style.filter = 'blur(5px)';
            devtoolsOpen = true;
        }
    } else {
        if (devtoolsOpen) {
            document.body.style.filter = 'none';
            devtoolsOpen = false;
        }
    }
};

// Check for developer tools at intervals
setInterval(checkDevTools, 1000);

document.addEventListener('visibilitychange', () => {
    if (document.visibilityState === 'hidden') {
        document.body.style.filter = 'blur(10px)';
    } else {
        document.body.style.filter = 'none';
    }
});
setInterval(() => {
    const devtoolsOpen = /HeadlessChrome/.test(navigator.userAgent) || window.outerHeight - window.innerHeight > 100;
    if (devtoolsOpen) {
        document.body.style.filter = 'blur(10px)';
    }
}, 1000);