'use strict';

// Component con CHỈ ĐỌC props; mọi thay đổi đều do cha xử lý.
window.DongGioHang = {
  name: 'DongGioHang',
  props: {
    sanPham: { type: Object, required: true }
  },
  emits: ['doi-so-luong', 'yeu-cau-xoa'],
  computed: {
    thanhTien() { return this.sanPham.donGia * this.sanPham.soLuong; }
  },
  methods: {
    dinhDangTien(gia) { return new Intl.NumberFormat('vi-VN').format(gia) + ' ₫'; },
    phatSoLuong(soLuongMoi) {
      this.$emit('doi-so-luong', { id: this.sanPham.id, soLuongMoi });
    },
    capNhatTuO(event) {
      const chuoi = event.target.value;
      // Không dùng parseInt: "2.5" không được bị chấp nhận thành 2.
      const giaTri = chuoi.trim() === '' ? NaN : Number(chuoi);
      this.phatSoLuong(giaTri);
      // Nếu cha bác bỏ giá trị, trả hiển thị về props hiện tại (không sửa props).
      if (!Number.isInteger(giaTri) || giaTri < 1 || giaTri > 99) {
        event.target.value = String(this.sanPham.soLuong);
      }
    },
    phatYeuCauXoa() { this.$emit('yeu-cau-xoa', this.sanPham.id); }
  },
  template: `
    <div class="cart-item">
      <div class="cart-item-symbol" aria-hidden="true">{{ sanPham.id === 1 ? '🖊️' : '📓' }}</div>
      <div class="cart-item-info">
        <div class="cart-item-name">{{ sanPham.ten }}</div>
        <div class="cart-item-price">Đơn giá: {{ dinhDangTien(sanPham.donGia) }}</div>
      </div>
      <div class="cart-item-right">
        <div class="cart-item-top">Thành tiền</div>
        <div class="cart-item-total">{{ dinhDangTien(thanhTien) }}</div>
        <div class="cart-item-controls">
          <div class="quantity-control">
            <button type="button" :disabled="sanPham.soLuong <= 1" :aria-label="'Giảm số lượng ' + sanPham.ten" @click="phatSoLuong(sanPham.soLuong - 1)">−</button>
            <input type="number" min="1" max="99" step="1" :value="sanPham.soLuong" :aria-label="'Số lượng ' + sanPham.ten" @change="capNhatTuO">
            <button type="button" :disabled="sanPham.soLuong >= 99" :aria-label="'Tăng số lượng ' + sanPham.ten" @click="phatSoLuong(sanPham.soLuong + 1)">+</button>
          </div>
          <button type="button" class="btn btn-danger-light btn-small" :aria-label="'Xóa ' + sanPham.ten" @click="phatYeuCauXoa">Xóa</button>
        </div>
      </div>
    </div>
  `
};
