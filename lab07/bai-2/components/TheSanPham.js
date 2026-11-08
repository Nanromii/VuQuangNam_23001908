'use strict';

// Tên component trong template: <the-san-pham>.
// Component này không tự giữ danh sách sản phẩm, chỉ nhận props từ cha.
window.TheSanPham = {
  name: 'TheSanPham',
  props: {
    ten: { type: String, required: true },
    gia: { type: Number, required: true },
    anh: { type: String, default: '../assets/images/san-pham-mac-dinh.svg' },
    moTa: { type: String, default: 'Chưa có mô tả cho sản phẩm này.' },
    soLuongTon: { type: Number, default: 0 }
  },
  emits: ['chon-mua'],
  data() {
    // Mỗi instance có một trạng thái riêng, không dùng biến toàn cục.
    return { dangMoMoTa: false };
  },
  methods: {
    dinhDangTien(gia) { return new Intl.NumberFormat('vi-VN').format(gia) + ' ₫'; },
    batTatMoTa() { this.dangMoMoTa = !this.dangMoMoTa; },
    muaSanPham() {
      if (this.soLuongTon > 0) this.$emit('chon-mua', this.ten);
    }
  },
  template: `
    <article class="catalog-card">
      <div class="catalog-image"><img :src="anh" :alt="'Ảnh minh họa ' + ten" loading="lazy"></div>
      <div class="catalog-content">
        <div class="catalog-top"><span class="catalog-category">SẢN PHẨM</span><span class="stock-pill" :class="soLuongTon > 0 ? 'in-stock' : 'out-stock'">{{ soLuongTon > 0 ? 'Còn hàng' : 'Hết hàng' }}</span></div>
        <h3>{{ ten }}</h3>
        <div class="catalog-price">{{ dinhDangTien(gia) }}</div>
        <div class="catalog-stock">{{ soLuongTon > 0 ? 'Tồn kho: ' + soLuongTon + ' sản phẩm' : 'Tạm thời hết hàng' }}</div>
        <p v-if="dangMoMoTa" class="catalog-description">{{ moTa }}</p>
        <div class="catalog-actions">
          <button type="button" class="btn btn-outline" :aria-expanded="dangMoMoTa" @click="batTatMoTa">{{ dangMoMoTa ? 'Ẩn mô tả' : 'Xem mô tả' }}</button>
          <button type="button" class="btn btn-primary" :disabled="soLuongTon === 0" @click="muaSanPham">Mua</button>
        </div>
      </div>
    </article>
  `
};
