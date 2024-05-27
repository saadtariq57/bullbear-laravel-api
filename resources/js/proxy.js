import { createServer } from 'cors-anywhere';

const PORT = process.env.PORT || 8000;

createServer({
    originWhitelist: [], // Allow all origins
    requireHeader: [],
    removeHeaders: ['cookie', 'cookie2']
}).listen(PORT, () => {
    console.log(`CORS Anywhere server is running on port ${PORT}`);
});