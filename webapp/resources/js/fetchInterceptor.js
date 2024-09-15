import { usePage } from '@inertiajs/vue3';

export default {
    install: (app) => {
        // Save the original fetch function reference
        const originalFetch = window.fetch;

        // Intercept all fetch requests
        window.fetch = async (input, init = {}) => {
            // Get the CSRF token from the `usePage` object
            const xpage = usePage();
            const csrfToken = xpage.props.csrf_token;

            // Set default headers for all requests
            const defaultHeaders = {
                'Content-Type': 'application/json',
                'x-csrf-token': csrfToken,
            };

            // Merge the default headers with any existing headers
            init.headers = {
                ...defaultHeaders,
                ...init.headers,
            };

            // Call the original fetch function with the new parameters
            return originalFetch(input, init);
        };
    },
};