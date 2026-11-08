'use strict';

// BÀI 1: dữ liệu ban đầu có ít nhất 6 sản phẩm, thuộc đúng 3 danh mục.
const { createApp } = Vue;

createApp({
  data() {
    return {
      trangThai: 'Đang khởi tạo',
      sanPhams: [
        { id: 1, ten: 'Laptop Dell Inspiron', gia: 18990000, danhMuc: 'Điện tử', soLuongTon: 4 },
        { id: 2, ten: 'Tai nghe Bluetooth', gia: 890000, danhMuc: 'Điện tử', soLuongTon: 0 },
        { id: 3, ten: 'Bút bi xanh', gia: 5000, danhMuc: 'Văn phòng phẩm', soLuongTon: 80 },
        { id: 4, ten: 'Vở kẻ ngang', gia: 12000, danhMuc: 'Văn phòng phẩm', soLuongTon: 35 },
        { id: 5, ten: 'Balo đi học', gia: 450000, danhMuc: 'Phụ kiện', soLuongTon: 10 },
        { id: 6, ten: 'Bình nước giữ nhiệt', gia: 265000, danhMuc: 'Phụ kiện', soLuongTon: 0 }
      ],
      tuKhoa: '',
      danhMucLoc: '',
      sapXepGia: 'mac-dinh',
      thongBaoTuKhoa: '',
      thongBaoThaoTac: '',
      loaiThongBao: 'success',
      sanPhamMoi: { ten: '', gia: '', danhMuc: 'Điện tử', soLuongTon: 0 },
      loiTruong: { ten: '', gia: '', soLuongTon: '' }
    };
  },
  computed: {
    danhMuc() {
      // Giữ danh mục ổn định, kể cả khi người dùng xóa hết sản phẩm.
      return ['Điện tử', 'Văn phòng phẩm', 'Phụ kiện'];
    },
    sanPhamHienThi() {
      const tuKhoaChuan = this.chuanHoaChuoi(this.tuKhoa);
      // Luôn sao chép mảng. Không sort() trực tiếp this.sanPhams.
      const ketQua = [...this.sanPhams].filter((sanPham) => {
        const khopTen = this.chuanHoaChuoi(sanPham.ten).includes(tuKhoaChuan);
        const khopDanhMuc = !this.danhMucLoc || sanPham.danhMuc === this.danhMucLoc;
        return khopTen && khopDanhMuc;
      });
      if (this.sapXepGia === 'tang') ketQua.sort((a, b) => a.gia - b.gia);
      if (this.sapXepGia === 'giam') ketQua.sort((a, b) => b.gia - a.gia);
      return ketQua;
    },
    soLuongHienThi() { return this.sanPhamHienThi.length; },
    soLuongTong() { return this.sanPhams.length; },
    tongGiaTriTonKho() {
      return this.sanPhamHienThi.reduce((tong, sanPham) => tong + sanPham.gia * sanPham.soLuongTon, 0);
    },
    soMatHangCon() { return this.sanPhamHienThi.filter((sanPham) => sanPham.soLuongTon > 0).length; }
  },
  watch: {
    tuKhoa(giaTriMoi) {
      this.thongBaoTuKhoa = giaTriMoi.length === 1
        ? 'Từ khóa hiện có đúng 1 ký tự. Hãy nhập thêm để tìm kiếm chính xác hơn.'
        : '';
    }
  },
  mounted() {
    this.trangThai = 'Sẵn sàng';
  },
  methods: {
    chuanHoaChuoi(chuoi) {
      // Không phân biệt hoa/thường; hỗ trợ tìm không dấu (cải thiện thêm).
      return String(chuoi).normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLocaleLowerCase('vi').trim();
    },
    dinhDangTien(gia) { return new Intl.NumberFormat('vi-VN').format(gia) + ' ₫'; },
    datLaiBoLoc() { this.tuKhoa = ''; this.danhMucLoc = ''; this.sapXepGia = 'mac-dinh'; },
    themSanPham() {
      const ten = String(this.sanPhamMoi.ten).trim();
      const gia = Number(this.sanPhamMoi.gia);
      const soLuongTon = Number(this.sanPhamMoi.soLuongTon);
      this.loiTruong = { ten: '', gia: '', soLuongTon: '' };
      if (!ten) this.loiTruong.ten = 'Tên không được để trống.';
      if (this.sanPhamMoi.gia === '' || !Number.isFinite(gia) || gia <= 0) {
        this.loiTruong.gia = 'Giá phải lớn hơn 0.';
      }
      if (this.sanPhamMoi.soLuongTon === '' || !Number.isInteger(soLuongTon) || soLuongTon < 0) {
        this.loiTruong.soLuongTon = 'Tồn kho phải là số nguyên ≥ 0.';
      }
      if (Object.values(this.loiTruong).some(Boolean)) {
        this.thongBaoThaoTac = 'Dữ liệu chưa hợp lệ. Vui lòng kiểm tra các trường được đánh dấu.';
        this.loaiThongBao = 'error';
        return;
      }
      const idMoi = this.sanPhams.reduce((max, sp) => Math.max(max, sp.id), 0) + 1;
      this.sanPhams.push({ id: idMoi, ten, gia, danhMuc: this.sanPhamMoi.danhMuc, soLuongTon });
      this.sanPhamMoi = { ten: '', gia: '', danhMuc: this.danhMuc[0], soLuongTon: 0 };
      this.thongBaoThaoTac = `Đã thêm sản phẩm “${ten}” thành công.`;
      this.loaiThongBao = 'success';
    },
    xoaSanPham(sanPham) {
      if (!window.confirm(`Bạn có chắc muốn xóa sản phẩm “${sanPham.ten}” không?`)) return;
      this.sanPhams = this.sanPhams.filter((item) => item.id !== sanPham.id);
      if (this.danhMucLoc && !this.danhMuc.includes(this.danhMucLoc)) this.danhMucLoc = '';
      this.thongBaoThaoTac = `Đã xóa sản phẩm “${sanPham.ten}”.`;
      this.loaiThongBao = 'success';
    }
  }
}).mount('#app');
