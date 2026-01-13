// Array of hex color codes
const colors = ['#65a30d', '#81bd2c', '#8E44AD', '#F1C40F', '#1a7dbc'];

let index = 0;
const interval = 10000; // Time in ms between color changes

// Helper function to check if dark mode is active
function isDarkMode() {
    return document.documentElement.classList.contains('dark') || 
           localStorage.getItem('darkMode') === 'true' ||
           (!localStorage.getItem('darkMode') && true); // Default to dark mode
}

function changeBackgroundColor() {
    // Only change background color if dark mode is active
    if (!isDarkMode()) {
        return;
    }
    
    // Remove the initial inline style if it exists so we can change colors
    const initialStyle = document.getElementById('initial-bg-color');
    if (initialStyle) {
        initialStyle.remove();
    }
    
    document.body.style.backgroundColor = colors[index];
    index = (index + 1) % colors.length;
}

let colorInterval = null;

// Function to start color cycling
function startColorCycling() {
    if (colorInterval) {
        clearInterval(colorInterval);
    }
    
    if (isDarkMode()) {
        // Don't change color immediately - let the interval handle it
        // This preserves the initial color set in init()
        colorInterval = setInterval(() => {
            if (isDarkMode()) {
                changeBackgroundColor();
            } else {
                // Stop cycling if user switches to light mode
                stopColorCycling();
            }
        }, interval);
    }
}

// Function to stop color cycling
function stopColorCycling() {
    if (colorInterval) {
        clearInterval(colorInterval);
        colorInterval = null;
    }
    // Reset background color when switching to light mode
    if (!isDarkMode() && document.body) {
        document.body.style.backgroundColor = '';
    }
}

// Wait for DOM to be ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}

function init() {
    // Initial color set (only if dark mode)
    if (isDarkMode()) {
        // Remove the initial inline style so we can control the color
        const initialStyle = document.getElementById('initial-bg-color');
        if (initialStyle) {
            initialStyle.remove();
        }
        
        // Set initial background color immediately
        document.body.style.backgroundColor = '#65a30d';
        index = 1; // Set index to 1 so first cycle goes to next color
        startColorCycling();
    }

    // Function to handle dark mode changes
    function handleDarkModeChange() {
        if (isDarkMode()) {
            // Set initial background color when switching to dark mode
            document.body.style.backgroundColor = '#65a30d';
            index = 1; // Set index to 1 so first cycle goes to next color
            startColorCycling();
        } else {
            // Stop cycling and reset background when switching to light mode
            stopColorCycling();
        }
    }

    // Listen for class changes on html element (Alpine.js updates this)
    const observer = new MutationObserver(() => {
        handleDarkModeChange();
    });
    
    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['class']
    });

    // Also listen for localStorage changes (for cross-tab updates)
    window.addEventListener('storage', () => {
        handleDarkModeChange();
    });

    // Override localStorage.setItem to catch darkMode changes in the same tab
    const originalSetItem = localStorage.setItem;
    localStorage.setItem = function(key, value) {
        originalSetItem.apply(this, arguments);
        if (key === 'darkMode') {
            // Small delay to let Alpine.js update the class
            setTimeout(() => {
                handleDarkModeChange();
            }, 10);
        }
    };
}
