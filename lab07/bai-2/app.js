'use strict';

const { createApp } = Vue;

const ungDung = createApp({
  data() {
    // Component CHA là chủ sở hữu duy nhất của danh sách.
    return {
      thongBao: '',
      sanPhams: [
        { id: 1, ten: 'Laptop học tập', gia: 15990000, anh: '../assets/images/laptop.svg', moTa: 'Laptop 14 inch, thiết kế gọn nhẹ, phù hợp học tập, làm việc và lập trình cơ bản.', soLuongTon: 8 },
        { id: 2, ten: 'Tai nghe không dây', gia: 690000, anh: '../assets/images/tai-nghe.svg', moTa: 'Tai nghe Bluetooth kết nối nhanh, pin lâu, phù hợp nghe nhạc và học trực tuyến.', soLuongTon: 0 },
        { id: 3, ten: 'Balo đa năng', gia: 420000, anh: '../assets/images/balo.svg', moTa: 'Balo chất liệu chống nước nhẹ, có ngăn đựng laptop và nhiều ngăn phụ tiện dụng.', soLuongTon: 12 },
        { id: 4, ten: 'Bình nước giữ nhiệt', gia: 250000, anh: '../assets/images/binh-nuoc.svg', moTa: 'Bình thép không gỉ, giữ nhiệt tốt, dung tích 600 ml, tiện mang theo mỗi ngày.', soLuongTon: 6 }
      ]
    };
  },
  methods: {
    chonMua(ten) { this.thongBao = `Đã chọn mua “${ten}” (thông báo minh họa cho Bài 2).`; }
  }
});

// Đăng ký component trước khi mount (theo đề bài).
ungDung.component('the-san-pham', window.TheSanPham);
ungDung.mount('#app');
