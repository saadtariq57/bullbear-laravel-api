import axios from 'axios';

const examStoreModule = {
    namespaced: true,
    state: () => ({
        examId: null,
        examName: '',
        timeLimit: 0,
        examQuestions: [],
        currentQuestionIndex: 0,
        userAnswers: [],
    }),
    mutations: {
        setExam(state, { examId, examName, timeLimit }) {
            state.examId = examId;
            state.examName = examName;
            state.timeLimit = timeLimit;
        },
        setExamQuestions(state, questions) {
            state.examQuestions = questions;
        },
        setCurrentQuestionIndex(state, index) {
            state.currentQuestionIndex = index;
        },
        addUserAnswer(state, answer) {
            state.userAnswers.push(answer);
        },
        resetExam(state) {
            state.examId = null;
            state.examName = '';
            state.timeLimit = 0;
            state.examQuestions = [];
            state.currentQuestionIndex = 0;
            state.userAnswers = [];
        },
    },
    actions: {
        async initiateExam({ commit }, examId) {
            try {
                const response = await axios.get(`/api/exams/initiate/${examId}`);
                
                const { firstQuestionId, examName, timeLimit, examId: id } = response.data;
                commit('setExam', { examId: id, examName, timeLimit });
                return { firstQuestionId, examName };
            } catch (error) {
                console.error("Error initiating exam:", error);
                throw error;
            }
        },
        async fetchExamQuestions({ commit, state }) {
            try {
                const response = await axios.get(`/api/exams/${state.examId}/questions`);
                commit('setExamQuestions', response.data.questions);
            } catch (error) {
                console.error("Error fetching exam questions:", error);
                throw error;
            }
        },
        submitExam({ state }) {
            return axios.post(`/api/exams/submit/${state.examId}`, {
                userAnswers: state.userAnswers,
            });
        },
        addAnswer({ commit }, answer) {
            commit('addUserAnswer', answer);
        },
        resetExamState({ commit }) {
            commit('resetExam');
        },
    },
    getters: {
        totalQuestions(state) {
            return state.examQuestions.length;
        },
        isLastQuestion(state) {
            return state.currentQuestionIndex === state.examQuestions.length - 1;
        },
        currentQuestion(state) {
            return state.examQuestions[state.currentQuestionIndex] || null;
        },
        examProgress(state, getters) {
            return ((state.currentQuestionIndex + 1) / getters.totalQuestions) * 100;
        },
    }
};

export default examStoreModule;
