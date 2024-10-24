import axios from 'axios';

const state = () => ({
    ebooks: [],
    videos: [],
    courses: [],
});

const getters = {
    getEbooks: (state) => state.ebooks,
    getVideos: (state) => state.videos,
    getCourses: (state) => state.courses,
};

const actions = {
    async fetchEbooks({ commit }) {
        try {
            const cachedEbooks = localStorage.getItem('ebooks');
            if (cachedEbooks) {
                commit('setEbooks', JSON.parse(cachedEbooks));
                return;
            }
            const response = await axios.get('/api/ebooks');
            commit('setEbooks', response.data);
            localStorage.setItem('ebooks', JSON.stringify(response.data));
        } catch (error) {
            console.error('Error fetching E-books:', error);
        }
    },
    async fetchVideos({ commit }) {
        try {
            const cachedVideos = localStorage.getItem('videos');
            if (cachedVideos) {
                commit('setVideos', JSON.parse(cachedVideos));
                return;
            }
            const response = await axios.get('/api/videos');
            commit('setVideos', response.data);
            localStorage.setItem('videos', JSON.stringify(response.data));
        } catch (error) {
            console.error('Error fetching videos:', error);
        }
    },
    async fetchCourses({ commit }) {
        try {
            const cachedCourses = localStorage.getItem('courses');
            if (cachedCourses) {
                commit('setCourses', JSON.parse(cachedCourses));
                return;
            }
            const response = await axios.get('/api/courses');
            commit('setCourses', response.data);
            localStorage.setItem('courses', JSON.stringify(response.data));
        } catch (error) {
            console.error('Error fetching courses:', error);
        }
    },
    clearCache({ commit }) {
        commit('clearEbooks');
        commit('clearVideos');
        commit('clearCourses');
        localStorage.removeItem('ebooks');
        localStorage.removeItem('videos');
        localStorage.removeItem('courses');
    },
};

const mutations = {
    setEbooks(state, ebooks) {
        state.ebooks = ebooks;
    },
    setVideos(state, videos) {
        state.videos = videos;
    },
    setCourses(state, courses) {
        state.courses = courses;
    },
    clearEbooks(state) {
        state.ebooks = [];
    },
    clearVideos(state) {
        state.videos = [];
    },
    clearCourses(state) {
        state.courses = [];
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
