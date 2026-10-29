// Bài 2: v-model.trim, v-model.number, radio, select, checkbox, computed, @submit.prevent.
const { createApp } = Vue;

createApp({
  data() {
    return {
      customerName: '',
      showtime: '18:00',
      ticketType: 'normal',
      quantity: 1,
      hasCombo: false,
      confirmation: null,
    };
  },
  computed: {
    ticketPrice() {
      return this.ticketType === 'vip' ? 100000 : 70000;
    },
    comboPrice() {
      return this.hasCombo ? 45000 : 0;
    },
    quantityIsValid() {
      return Number.isInteger(this.quantity) && this.quantity >= 1 && this.quantity <= 10;
    },
    totalPrice() {
      if (!this.quantityIsValid) return 0;
      return this.ticketPrice * this.quantity + this.comboPrice;
    },
    canBook() {
      return this.customerName.trim().length > 0 && this.quantityIsValid;
    },
  },
  methods: {
    formatCurrency(amount) {
      return new Intl.NumberFormat('vi-VN', {
        style: 'currency', currency: 'VND', maximumFractionDigits: 0,
      }).format(amount);
    },
    changeQuantity(delta) {
      if (!this.quantityIsValid) {
        this.quantity = 1;
        return;
      }
      this.quantity = Math.min(10, Math.max(1, this.quantity + delta));
    },
    bookTicket() {
      if (!this.canBook) return;
      this.confirmation = {
        customerName: this.customerName.trim(),
        showtime: this.showtime,
        ticketName: this.ticketType === 'vip' ? 'VIP' : 'Thường',
        quantity: this.quantity,
        hasCombo: this.hasCombo,
        total: this.totalPrice,
      };
    },
    resetForm() {
      this.customerName = '';
      this.showtime = '18:00';
      this.ticketType = 'normal';
      this.quantity = 1;
      this.hasCombo = false;
      this.confirmation = null;
    },
  },
}).mount('#app');
