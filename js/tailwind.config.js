/* ----------------------------------------------------
   IF Barber - Tailwind Configuration
   ---------------------------------------------------- */

// Ensure Tailwind CDN has loaded and initialized the global object,
// then mutate the config property to trigger re-rendering with custom theme.
tailwind.config = {
    darkMode: "class",
    theme: {
        extend: {
            colors: {
                "secondary-container": "#494851",
                "secondary": "#c7c5d0",
                "surface-variant": "#333537",
                "on-tertiary-fixed-variant": "#47464a",
                "primary-fixed": "#ffe088",
                "surface": "#111415",
                "primary-container": "#d4af37",
                "error": "#ffb4ab",
                "on-primary-fixed-variant": "#574500",
                "surface-container-high": "#282a2c",
                "on-background": "#e2e2e4",
                "surface-container-lowest": "#0c0e10",
                "tertiary-container": "#b4b2b6",
                "on-error-container": "#ffdad6",
                "surface-bright": "#37393b",
                "on-tertiary": "#303033",
                "inverse-primary": "#735c00",
                "secondary-fixed": "#e4e1ec",
                "surface-container-highest": "#333537",
                "outline": "#99907c",
                "status-completed": "#4CAF50",
                "surface-dim": "#111415",
                "on-secondary-fixed": "#1b1b23",
                "error-container": "#93000a",
                "inverse-on-surface": "#2f3132",
                "on-primary-fixed": "#241a00",
                "on-secondary-fixed-variant": "#46464f",
                "on-error": "#690005",
                "on-secondary": "#303038",
                "surface-tint": "#e9c349",
                "on-primary": "#3c2f00",
                "on-surface-variant": "#d0c5af",
                "inverse-surface": "#e2e2e4",
                "tertiary": "#d0cdd2",
                "tertiary-fixed": "#e4e1e6",
                "muted-gray": "#9E9E9E",
                "on-primary-container": "#554300",
                "primary": "#f2ca50",
                "on-tertiary-container": "#454448",
                "on-secondary-container": "#b9b7c2",
                "secondary-fixed-dim": "#c7c5d0",
                "on-surface": "#e2e2e4",
                "surface-container-low": "#1a1c1d",
                "on-tertiary-fixed": "#1b1b1e",
                "status-progress": "#2196F3",
                "tertiary-fixed-dim": "#c8c5ca",
                "gold-hover": "#F3E5AB",
                "surface-container": "#1e2021",
                "status-waiting": "#FFC107",
                "primary-fixed-dim": "#e9c349",
                "outline-variant": "#4d4635",
                "background": "#111415"
            },
            borderRadius: {
                "DEFAULT": "0.25rem",
                "lg": "0.5rem",
                "xl": "0.75rem",
                "full": "9999px"
            },
            spacing: {
                "container-max": "1280px",
                "margin-desktop": "48px",
                "section-gap": "80px",
                "margin-mobile": "16px",
                "unit": "4px",
                "stack-sm": "8px",
                "gutter": "24px",
                "stack-lg": "32px",
                "stack-md": "16px"
            },
            fontFamily: {
                "headline-xl-mobile": ["Outfit"],
                "body-md": ["Inter"],
                "label-sm": ["Inter"],
                "label-md": ["Inter"],
                "headline-xl": ["Outfit"],
                "body-lg": ["Inter"],
                "display-lg": ["Outfit"],
                "display-lg-mobile": ["Outfit"],
                "headline-md": ["Outfit"]
            },
            fontSize: {
                "headline-xl-mobile": ["28px", { "lineHeight": "1.3", "fontWeight": "600" }],
                "body-md": ["16px", { "lineHeight": "1.6", "fontWeight": "400" }],
                "label-sm": ["12px", { "lineHeight": "1.2", "fontWeight": "500" }],
                "label-md": ["14px", { "lineHeight": "1.2", "letterSpacing": "0.05em", "fontWeight": "600" }],
                "headline-xl": ["36px", { "lineHeight": "1.3", "fontWeight": "600" }],
                "body-lg": ["18px", { "lineHeight": "1.6", "fontWeight": "400" }],
                "display-lg": ["64px", { "lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                "display-lg-mobile": ["40px", { "lineHeight": "1.2", "letterSpacing": "-0.01em", "fontWeight": "700" }],
                "headline-md": ["24px", { "lineHeight": "1.4", "fontWeight": "500" }]
            }
        }
    }
};
