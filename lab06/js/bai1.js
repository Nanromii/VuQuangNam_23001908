// Bài 1: createApp, data, interpolation, v-text, v-bind, v-if, v-show, :class.
const { createApp } = Vue;

const defaultStudent = () => ({
  id: 'SV001',
  name: 'Vũ Quang Nam',
  className: 'CNTT-K24',
  avatar: 'assets/student-avatar.svg',
  gpa: 10.0,
  isStudying: true,
});

createApp({
  data() {
    return { student: defaultStudent(), showIntro: true };
  },
  computed: {
    classification() {
      const score = Number(this.student.gpa);
      if (this.student.gpa === '' || !Number.isFinite(score) || score < 0 || score > 10) {
        return 'Điểm không hợp lệ';
      }
      if (score >= 8) return 'Giỏi';
      if (score >= 6.5) return 'Khá';
      if (score >= 5) return 'Trung bình';
      return 'Chưa đạt';
    },
    gradeClass() {
      return {
        'Giỏi': 'grade-good',
        'Khá': 'grade-fair',
        'Trung bình': 'grade-average',
        'Chưa đạt': 'grade-poor',
      }[this.classification] || 'grade-poor';
    },
  },
  methods: {
    formatGpa(value) {
      if (value === '' || !Number.isFinite(Number(value))) return '—';
      return new Intl.NumberFormat('vi-VN', { maximumFractionDigits: 2 }).format(Number(value));
    },
    useDefaultAvatar(event) {
      // Chống vòng lặp nếu chính ảnh mặc định không tải được.
      if (!event.target.src.endsWith('/assets/student-avatar.svg')) {
        event.target.src = 'assets/student-avatar.svg';
      }
    },
    resetStudent() {
      this.student = defaultStudent();
      this.showIntro = true;
    },
  },
}).mount('#app');
