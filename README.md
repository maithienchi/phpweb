Đề tài: Mạng xã hội
Thành viên: 1 đến 4
Nộp bài hàng tuần trên Moodle theo BTN (một thành viên đại diện)
Đặt tên tập tin: MSSV1_MSSV2_MSSV3_MSSV4_xx.zip/rar (xx: điểm tự đánh giá như BTCN)
Đăng ký nhóm: Theo danh sách nộp bài nhóm lần 1
Hình thức chấm: 50% BTN + 50% vấn đáp cuối kỳ
Vấn đáp với GVLT vào buổi thi cuối kỳ trên phòng, theo lịch PĐT
Tất cả thành viên đều phải commit lên github trong toàn bộ thời gian làm đồ án. Nhóm/thành viên không commit đầy đủ có thể bị trừ đến 40% điểm đồ án

Yêu cầu:
- Xây dựng đồ án bằng PHP, MySQL, HTML, JS, CSS
- Có thể sử dụng các framework PHP có sẵn: Laravel, Symfony, Zend... hoặc dựa trên BTCN
- Khuyến khích sử dụng các thư viên CSS như Bootstrap

Chức năng:
- Đăng nhập, đăng xuất, quên mật khẩu bằng email, đăng ký và kích hoạt tài khoản bằng email
- Thông tin người dùng: Họ tên, email, mật khẩu, số điện thoại, hình ảnh đại diện, năm sinh
- Cập nhật thông tin cá nhân
- Trang chủ:
  + Hiển thị các bài viết mới của các thành viên (mà người dùng đó được quyền thấy) theo dòng thời gian (từ mới đến cũ)
  + Phân trang hoặc tự động tải nội dung tiếp theo với không quá 10 tin/trang
  + Hiển thị tên người đăng kèm hình đại diện, thời gian đăng, nội dung bài viết (văn bản + hình ảnh)
- Trang cá nhân:
  + Hình đại diện, tên và các thông tin khác (không riêng tư)
  + Các bài viết tương tự như trang chủ nhưng chỉ của cá nhân đó
  + Nút theo dõi/huỷ theo dõi/gửi yêu cầu kết bạn/chấp nhận yêu cầu/huỷ yêu cầu
- Bài viết:
  + Nội dung văn bản
  + Kèm một hình ảnh (tuỳ chọn: có thể nhiều hơn 1)
  + Quyền riêng tư (cá nhân, bạn bè, công khai), có thể thay đổi sau khi đăng
- Bạn bè/Theo dõi:
  + Người dùng có thể theo dõi tin tức từ người dùng khác
  + Người dùng có thể kết bạn với nhau thông qua yêu cầu kết bạn, có thể từ chối
- Tin nhắn riêng (chat):
  + Người dùng có thể gửi tin nhắn cho nhau 1-1
  + Xem nội dung tin nhắn
  + Xoá tin nhắn (mà người dùng nhận được)
- Thông báo:
  + Nhận được yêu cầu kết bạn (của ai, link đến trang cá nhân của người gửi)
  + Nhận được tin nhắn mới (của ai, nội dung tóm tắt)
  + Thông báo được gửi đến email của người nhận (tuỳ chọn: SMS)
- Tương tác (trên những nội dung thấy được):
  + Người dùng có thể thích/bỏ thích một bài viết
  + Người dùng có thể bình luận trên một bài viết
