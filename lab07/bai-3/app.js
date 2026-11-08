'use strict';

const { createApp } = Vue;

// 2 * 5.000 + 3 * 12.000 = 46.000 VNĐ (theo yêu cầu kiểm tra đề bài).
function taoGioMau() {
  return [
    { id: 1, ten: 'Bút bi xanh', donGia: 5000, soLuong: 2 },
    { id: 2, ten: 'Vở kẻ ngang', donGia: 12000, soLuong: 3 }
  ];
}

const ungDung = createApp({
  data() {
    return { gioHang: taoGioMau(), thongBaoLoi: '' };
  },
  computed: {
    tongSoLuong() { return this.gioHang.reduce((tong, item) => tong + item.soLuong, 0); },
    tongTien() { return this.gioHang.reduce((tong, item) => tong + item.soLuong * item.donGia, 0); }
  },
  methods: {
    dinhDangTien(gia) { return new Intl.NumberFormat('vi-VN').format(gia) + ' ₫'; },
    doiSoLuong({ id, soLuongMoi }) {
      // Xác minh cả mã sản phẩm và miền giá trị tại CHA.
      const sanPham = this.gioHang.find((item) => item.id === id);
      if (!sanPham || !Number.isInteger(soLuongMoi) || soLuongMoi < 1 || soLuongMoi > 99) {
        this.thongBaoLoi = 'Số lượng không hợp lệ: chỉ được nhập số nguyên từ 1 đến 99.';
        return;
      }
      // Không thao tác từ component con, chỉ cha thay đổi dữ liệu.
      sanPham.soLuong = soLuongMoi;
      this.thongBaoLoi = '';
    },
    xoaSanPham(id) {
      if (!this.gioHang.some((item) => item.id === id)) return;
      this.gioHang = this.gioHang.filter((item) => item.id !== id);
      this.thongBaoLoi = '';
    },
    khoiPhucGioMau() { this.gioHang = taoGioMau(); this.thongBaoLoi = ''; }
  }
});

ungDung.component('dong-gio-hang', window.DongGioHang);
ungDung.mount('#app');
