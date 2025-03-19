export const loader = `<svg class="mr-3 -ml-1 size-5 animate-spin text-white stroke-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10"  stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>`;

/**
 * Copies text content to the clipboard using the Navigator Clipboard API
 * @param {string} content - The text to copy to clipboard
 * @returns {Promise<void>} - Resolves when copy is successful, rejects on failure
 * @throws {TypeError} - If input is not a string
 */
export async function copyToClipboard(content) {
    // Early return for invalid input
    if (typeof content !== 'string') {
        throw new TypeError('Input must be a string');
    }

    try {
        // Check if clipboard API is available
        if (!navigator.clipboard) {
            throw new Error('Clipboard API not supported');
        }
        await navigator.clipboard.writeText(content);
    } catch (error) {
        console.error('Failed to copy to clipboard:', error);
        throw error; // Re-throw for caller handling if needed
    }
}
