// Bài 3: v-for, :key, checkbox, methods, computed, @keyup.enter.
const { createApp } = Vue;

createApp({
  data() {
    return {
      newTask: '',
      filter: 'all',
      nextId: 4,
      tasks: [
        { id: 1, title: 'Ôn tập VueJS', completed: true },
        { id: 2, title: 'Hoàn thành bài thực hành', completed: false },
        { id: 3, title: 'Kiểm tra kết quả', completed: false },
      ],
    };
  },
  computed: {
    totalTasks() {
      return this.tasks.length;
    },
    pendingTasks() {
      return this.tasks.filter(task => !task.completed).length;
    },
    completedTasks() {
      return this.tasks.filter(task => task.completed).length;
    },
    filteredTasks() {
      if (this.filter === 'pending') return this.tasks.filter(task => !task.completed);
      if (this.filter === 'done') return this.tasks.filter(task => task.completed);
      return this.tasks;
    },
  },
  methods: {
    addTask() {
      const title = this.newTask.trim();
      if (!title) return;
      this.tasks.push({ id: this.nextId++, title, completed: false });
      this.newTask = '';
    },
    removeTask(id) {
      this.tasks = this.tasks.filter(task => task.id !== id);
    },
    clearCompleted() {
      this.tasks = this.tasks.filter(task => !task.completed);
    },
  },
}).mount('#app');
